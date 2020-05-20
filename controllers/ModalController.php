<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\FeatureAnnounModalTutorialAssn;
use app\models\Modal;
use app\models\ModalSlide;
use yii\web\UploadedFile;
use app\components\utility\FormatDateFromPicker;
use yii\helpers\Url;

class ModalController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'edit', 'create', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
        
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Displays modal list page.
     *
     * @return string
     */
    public function actionIndex($for_delete = false)
    {

        $modals = Modal::find()->where(['for_delete' => $for_delete])->orderBy('name', 'asc')->all();
    
        return $this->render('index', [
            'modalWindows' => $modals,
        ]);
    }

    /**
     * Displays create modal window page.
     *
     * @return Response|string
     */
    public function actionCreate()
    {
        $model = new Modal();
        $errors = [];
        if (Yii::$app->request->post()) {
            $this->addTags($model, Yii::$app->request->post()['Modal']['tagValues']);
            $model->logoFile = UploadedFile::getInstance($model, 'logoFile');
            $model->load(Yii::$app->request->post());
            $form_data = Yii::$app->request->post()['Modal'];

            if ($model->validate()) {
                if (!empty($model->logoFile)) {
                    $model->logo = $model->upload();
                }
                
                $model->name = $form_data['name'];

                $model->auto_show = $form_data['auto_show'];
                if (empty($form_data['auto_show_start_date'])) {
                    $model->auto_show_start_date = FormatDateFromPicker::dbFormat('now');
                } else {
                    $model->auto_show_start_date = FormatDateFromPicker::dbFormat($form_data['auto_show_start_date']);
                }
                
                $model->category_id = $form_data['category_id'];
                $model->theme_color = $form_data['theme_color'];
                $model->secondary_theme_color = $form_data['secondary_theme_color'];
                $model->feature_announ = $form_data['feature_announ'];
                $model->author_id = Yii::$app->user->identity->id;
                //TODO: remove when we don't need keep old modals
                $model->for_delete = 0;
                $model->save();
                header("Location: " . Url::base(true) . '/modal');
                exit(0);
            } else {
                $errors = $model->errors;
            }
        } else {
            // add default params for Modal. Need for FE display this options.
            $model->theme_color = Modal::PRIMARY_COLOR;
            $model->secondary_theme_color =  Modal::SECONDARY_COLOR;
            //Default value for start date
            $model->auto_show_start_date = FormatDateFromPicker::datePickerFormat('now');
        }

        return $this->render('create', [
            'model' => $model,
            'errors' => $errors
        ]);
    }

    /**
     * Displays edit modal window page.
     *
     * @return Response|string
     */
    public function actionEdit($id)
    {
        
        $model = Modal::findOne($id);
        $modal_slides = ModalSlide::find()->where(['modal_id' => $id])->orderBy('order')->all();
        $errors = [];

        if (Yii::$app->request->post()) {
            $this->addTags($model, Yii::$app->request->post()['Modal']['tagValues']);
            $model->logoFile = UploadedFile::getInstance($model, 'logoFile');
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if (!empty($model->logoFile)) {
                    $model->logo = $model->upload();
                }
                $form_data = Yii::$app->request->post()['Modal'];
                
                if ($model->feature_announ != $form_data['feature_announ']) {
                    self::updateFeatureAnnouncementAssn($model, $modal_slides, $form_data['feature_announ']);
                }
                $model->name = $form_data['name'];
                $model->show = (isset($form_data['show'])) ? $form_data['show'] : false;
                $model->auto_show = $form_data['auto_show'];
                
                if (empty($form_data['auto_show_start_date'])) {
                    $model->auto_show_start_date = FormatDateFromPicker::dbFormat('now');
                } else {
                    $model->auto_show_start_date = FormatDateFromPicker::dbFormat($form_data['auto_show_start_date']);
                }
                
                $model->category_id = $form_data['category_id'];
                $model->theme_color = $form_data['theme_color'];
                $model->secondary_theme_color = $form_data['secondary_theme_color'];
                $model->feature_announ = $form_data['feature_announ'];
                
                $model->save();
                header("Location: " . Url::base(true) . '/modal/edit?id=' . $id);
                exit(0);
                //return $this->refresh();
            } else {
                $errors = $model->errors;
            }
        }

        $modal_slides = ModalSlide::formatSlides($modal_slides);

        // flag for allow preview if at least one slide visible
        $has_visible_slides = self::hasVisibleSlides($modal_slides);
        //var_dump($model->auto_show_start_date);die;
        // format date for date picker
        $model->auto_show_start_date = FormatDateFromPicker::datePickerFormat($model->auto_show_start_date);

        //var_dump($model->auto_show_start_date);die;
        return $this->render('edit', [
            'model' => $model,
            'modal_slides' => $modal_slides,
            'has_visible_slides' => $has_visible_slides,
            'errors' => $errors
        ]);
    }
    

     /**
     * Delete modal window page.
     *
     * @param integer $id
     * @return Response|string
     */
    public function actionDelete($id)
    {
        $model = Modal::findOne($id);
        
        if (!empty($model)) {
            $model->delete();
            //return $this->redirect('/modal');
        }
        header("Location: " . Url::base(true) . '/modal' );
        exit(0);
        //return $this->refresh();
    }

    /**
     * Add tags to Modal
     * @param mixed $model
     * @param mixed $tags_list_string - tags list in string format
     * @return void
     */
    private function addTags($model, $tags_list_string)
    {
        $tags_array = explode(',', $tags_list_string);
        $model->addTagValues($tags_array);
    }

    /**
     * Define has modal window at least one visible slide
     *
     * @param object $modal_slides
     * @return boolean
     */
    public static function hasVisibleSlides($modal_slides)
    {
        $has_visible_slides = (!empty($modal_slides->start_slide->show)  || !empty($modal_slides->end_slide->show)) ? true :false;
        if (!$has_visible_slides && !empty($modal_slides->slides)) {
            foreach ($modal_slides->slides as $slide) {
                if ($slide->show) {
                    $has_visible_slides = true;
                    break;
                }
            }
        }
        return $has_visible_slides;
    }

    /**
     * Handle logic for Feature Announcement when update flag
     *
     * @param object $modal
     * @param object $slides
     * @param boolean $new_flag_value
     * @return void
     */
    private static function updateFeatureAnnouncementAssn($modal, $slides, $new_flag_value)
    {
        
        // flag change from TRUE to FALSE
        if (!empty($modal->feature_announ) && empty($new_flag_value)) {
            FeatureAnnounModalTutorialAssn::deleteAll(['feature_announ_modal_id' => $modal->id]);
        }

        // flag change from FALSE to TRUE
        if (empty($modal->feature_announ) && !empty($new_flag_value)) {
            foreach ($slides as $modal_slide) {
                FeatureAnnounModalTutorialAssn::handleFeatureAnnoun($modal->id, $modal_slide);
            }
        }
    }
}
