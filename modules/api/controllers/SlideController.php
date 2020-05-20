<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use app\models\Modal;
use app\models\ModalSlide;
use app\models\Template;
use app\components\utility\FormatApiResponse;

class SlideController extends Controller
{
    public $modelClass = 'app\models\ModalSlide';
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // add CORS filter
        
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];
        
        return $behaviors;
    }
    
    /**
     * Get modal window with slides
     *
     * @param integer $modal_id - id of modal window
     * @return object
     */
    public function actionIndex($modal_id)
    {
        $response = $this->getModalWithSlides($modal_id);
        return $response;
    }

    /**
     * Get one slide
     *
     * @param integer $id - modal slide id
     * @return object
     */
    public function actionView($id)
    {
        return Modal::findOne($id);
    }

    /**
     * Get all slides for modal window
     *
     * @param integer $modal_id - id of modal window
     * @return object
     */
    public function actionSlide($modal_id)
    {
        $modal_slides = ModalSlide::find()->where(['modal_id' => $modal_id])->all();
        return $modal_slides;
    }
    
    /**
     * Format response for FE
     *
     * @param array $data
     * @return object
     */
    public static function formatResponse($data)
    {
        foreach ($data as $key => $value) {
            // add host to file path
            if (in_array($key, ['file', 'logo']) && !empty($value)) {
                $data->{$key} = FormatApiResponse::addHost($data->{$key});
            }
            
            // convert to boolean
            if (in_array($key, ['show_button', 'show_description', 'product_tour_link_show', 'next_modal_link_show', 'button_action_next'])) {
                $data->{$key} = (boolean)$data->{$key};
            }

            // get code from youtube link
            if (in_array($key, ['youtube_link']) && !empty($value)) {
                $data->{$key} = FormatApiResponse::getYoutubeEmbedCode($data->{$key});
            }
        }
        
        return $data;
    }
    
    /**
     * Get modal window for auto show
     *
     * @param integer $unique_user_id - id of user
     * @return object
     */
    public function actionAuto($unique_user_id)
    {
        $interval_for_showing = 604800;// 7 days

        $tutorials_viewed_today_query = Modal::find()->select(
            'modal.*, tutorial_stats.unique_user_id, tutorial_stats.create_at'
        )->leftJoin(
            'tutorial_stats',
            'tutorial_stats.unique_user_id = "' . $unique_user_id . '" and `tutorial_stats`.`create_at` > (NOW() - interval 1 day)'
        )
        ->where([
                    'AND',
                    [
                        'not', ['tutorial_stats.unique_user_id' => null]
                    ],
                    ['auto_show' => 1, 'show' => 1 ]

                ])
        ->andWhere(['>','auto_show_start_date', date('Y-m-d H:i:s', time() - $interval_for_showing)])
        ->andWhere(['<','auto_show_start_date', date('Y-m-d H:i:s', time())])
        ->limit(1);
        //var_dump($tutorials_viewed_today_query->createCommand()->getRawSql());die;
        $viewed_today = $tutorials_viewed_today_query->all();
        
        if (empty($viewed_today)) {
            // get not viewed modals with auto_show flag true
            $tutorials_query = Modal::find()->select(
                'modal.*, tutorial_stats.unique_user_id'
            )->leftJoin(
                'tutorial_stats',
                'tutorial_stats.unique_user_id = "' . $unique_user_id . '" and modal.id = tutorial_stats.modal_id'
            )
            ->where([
                        'AND',
                        ['tutorial_stats.unique_user_id' => null],
                        [
                            'not', ['modal.id' => null]
                        ],
                        ['auto_show' => 1, 'show' => 1]

                    ])
            ->andWhere(['>','auto_show_start_date', date('Y-m-d H:i:s', time() - $interval_for_showing)])
            ->andWhere(['<','auto_show_start_date', date('Y-m-d H:i:s', time())])
            ->limit(1);

            // show sql query use $tutorials_query->createCommand()->getRawSql()
            
            $modals = $tutorials_query->all();
            
            if (!empty($modals[0]->id)) {
                return $this->getModalWithSlides($modals[0]->id);
            }
        }
         
        return [];
    }

    /**
     * Get modal window and visible slides
     *
     * @param integer $modal_id - id of modal window
     * @return void
     */
    private function getModalWithSlides($modal_id)
    {
        $modal_data = Modal::findOne($modal_id);
        $modal_slides = ModalSlide::find()->where(['modal_id' => $modal_id, 'show' =>true])->orderBy('order')->all();
        
        $modal_slides = ModalSlide::formatSlides($modal_slides);
        $response['endSlide'] = $response['startSlide'] = [];
        if (!empty($modal_slides->start_slide)) {
            $response['startSlide'] = self::formatResponse(json_decode($modal_slides->start_slide->slide_params));
        }
        
        if (!empty($modal_slides->end_slide)) {
            $response['endSlide'] = self::formatResponse(json_decode($modal_slides->end_slide->slide_params));
        }
        
        $response['slides'] = [];
        if (!empty($modal_slides->slides)) {
            foreach ($modal_slides->slides as $slide) {
                $response['slides'][] = self::slideFormatResponse($slide);
            }
        }
            
        $response['modal'] = self::formatResponse($modal_data);
        
        return $response;
    }

    /**
     * Format slide data for response
     *
     * @param object $slide
     * @return object
     */
    public static function slideFormatResponse($slide)
    {
        $slide_data = self::formatResponse(json_decode($slide->slide_params));
        $slide_data->template = Template::convertToString($slide->template_id);
        return $slide_data;
    }
}
