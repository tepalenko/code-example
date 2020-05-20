<?php

namespace app\modules\api\controllers;

use yii\rest\Controller;
use app\models\FeatureAnnounModalTutorialAssn;
use app\models\Modal;

class NotificationController extends Controller
{
    public $modelClass = 'app\models\Modal';

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
     * Get list of tutorials mark as notification
     *
     * @param integer $unique_user_id - id of user generated on FE side
     * @return array
     */
    public function actionIndex($unique_user_id)
    {
        // get not viewed tutorials added to feature announcement
        $tutorials_query = FeatureAnnounModalTutorialAssn::find()
        ->select(
            'feature_announ_modal_tutorial_assn.*, tutorial_stats.unique_user_id'
        )
        ->leftJoin(
            'tutorial_stats',
            'tutorial_stats.unique_user_id = "' . $unique_user_id . '" and 
            (feature_announ_modal_tutorial_assn.modal_id = tutorial_stats.modal_id or feature_announ_modal_tutorial_assn.product_tour_id = tutorial_stats.product_tour_id)'
        )
        ->where([
                    'AND',
                    ['tutorial_stats.unique_user_id' => null],
                    [
                        'OR',
                        ['not', ['feature_announ_modal_tutorial_assn.product_tour_id' => null]],
                        ['not', ['feature_announ_modal_tutorial_assn.modal_id' => null]]
                    ],

                ]);
                
        // show sql query use $tutorials_query->createCommand()->getRawSql()

        $tutorials = $tutorials_query->all();

        $response = [];
        // avoid duplicate tutorials in response
        $already_added_modal_ids = $already_added_product_tour_ids = [];
        foreach ($tutorials as $tutorial) {
            if (!empty($tutorial->modal_id)) {
                $modal_window = $tutorial->getModal()->asArray()->all();
                $modal_window = $modal_window[0];
                $modal_window['tutorialType'] = 'modal';

                $feature_modal_data = Modal::findOne($tutorial->feature_announ_modal_id);
                
                if ($modal_window['show'] &&
                    !in_array($modal_window['id'], $already_added_modal_ids) &&
                    (is_null($feature_modal_data->auto_show_start_date) || strtotime($feature_modal_data->auto_show_start_date) < time())
                ) {
                    $response[] = $modal_window;
                    $already_added_modal_ids[] = $modal_window['id'];
                }
            }
            
            if (!empty($tutorial->product_tour_id)) {
                $product_tour = $tutorial->getProductTour()->asArray()->all();
                $product_tour = $product_tour[0];
                $product_tour['tutorialType'] = 'productTour';
                if ($product_tour['show'] && !in_array($product_tour['id'], $already_added_product_tour_ids)) {
                    $response[] = $product_tour;
                    $already_added_product_tour_ids[] = $product_tour['id'];
                }
            }
        }

        return $response;
    }
}
