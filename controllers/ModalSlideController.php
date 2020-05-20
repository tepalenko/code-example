<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use app\models\ModalSlide;
use app\models\Modal;
use app\models\Template;
use app\models\FeatureAnnounModalTutorialAssn;
use app\models\DynamicTemplate;
use tuyakhov\youtube\CodeValidator;
use yii\helpers\Url;

class ModalSlideController extends Controller
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
                        'actions' => ['index', 'edit', 'create', 'delete', 'sort'],
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
     * Displays create modal window slide page.
     *
     * @param mixed $modal_id - id of modal
     * @param mixed $template_id - id of template from app\models\Template
     * @param mixed $slide_type - type of slide from app\models\ModalSlide (MODAL_SLIDE_REGULAR_TYPE, MODAL_SLIDE_FIRST_TYPE, MODAL_SLIDE_LAST_TYPE)
     * @return Response|string
     */
    public function actionCreate($modal_id, $template_id, $slide_type = 0)
    {
        $modal_slides = ModalSlide::find()->where(['modal_id' => $modal_id])->orderBy('order')->all();
        if (sizeof($modal_slides) > 7) {
            header("Location: " . Url::base(true) . '/modal/edit?id=' . $modal_id);
            //return $this->redirect(['modal/edit', 'id' => $modal_id]);
        }

        $modal_window = Modal::findOne($modal_id);
        
        // get params for particular template
        $template_params = Template::getFormParams($template_id);
        
        $form_params = $template_params;
        //add default modal slide params
        $form_params = array_merge($form_params, ['name', 'show']);
        
        $model = new DynamicTemplate($form_params);
        
        $model->template = Template::convertToString($template_id);
        $model->type = $slide_type;
        $model = $this->addTemplateValidateRules($model, $template_id, $template_params);
        $errors = [];

        if (Yii::$app->request->post()) {
            $modal_slide = new ModalSlide($template_params);

            $modal_slide->imageFile = UploadedFile::getInstance($model, 'imageFile');

            $modal_slide->load(Yii::$app->request->post());
            $model->load(Yii::$app->request->post());
            
            $form_data = Yii::$app->request->post()['DynamicTemplate'];
            
            // validate allowed image extension
            $valid_image = $valid_related_tutorials = true;
            if (!empty($modal_slide->imageFile)) {
                $valid_image = in_array($modal_slide->imageFile->type, DynamicTemplate::imageMIMETypes());

                if (!empty($form_data['related_tutorial_1_text']) ||
                    !empty($form_data['related_tutorial_2_text']) ||
                    !empty($form_data['related_tutorial_3_text']) ||
                    !empty($form_data['related_tutorial_4_text'])) {
                        $valid_related_tutorials = false;
                }
            }

            // TODO: can't find another way to validate those filds
            if (isset($model->related_tutorial_1_modal_id)) {
                $model->related_tutorial_1_modal_id = $form_data['related_tutorial_1_modal_id'];
                $model->related_tutorial_2_modal_id = $form_data['related_tutorial_2_modal_id'];
                $model->related_tutorial_3_modal_id = $form_data['related_tutorial_3_modal_id'];
                $model->related_tutorial_4_modal_id = $form_data['related_tutorial_4_modal_id'];

                $model->related_tutorial_1_product_tour_id = $form_data['related_tutorial_1_product_tour_id'];
                $model->related_tutorial_2_product_tour_id = $form_data['related_tutorial_2_product_tour_id'];
                $model->related_tutorial_3_product_tour_id = $form_data['related_tutorial_3_product_tour_id'];
                $model->related_tutorial_4_product_tour_id = $form_data['related_tutorial_4_product_tour_id'];
            }
            
            if ($modal_slide->validate() && $valid_image && $valid_related_tutorials && $model->validate()) {
                if (in_array('imageFile', $template_params) && !empty($modal_slide->imageFile)) {
                    $file_upload = $modal_slide->upload();
                    unset($template_params['imageFile']);
                    $modal_slide->file = $file_upload;
                }
                
                // handle params for particular template
                foreach ($template_params as $param_name) {
                    if (isset($form_data[$param_name])) {
                        $modal_slide->{$param_name} = $form_data[$param_name];
                    }
                }
                
                //handle default slide params
                $modal_slide->name = $form_data['name'];
                $modal_slide->type = $form_data['type'];
                $modal_slide->modal_id = $modal_id;
                $modal_slide->template_id = $template_id;
                
                if (!empty($modal_window->feature_announ) && (isset($modal_slide->button_modal_id) ||  isset($modal_slide->button_product_tour_id))) {
                    FeatureAnnounModalTutorialAssn::handleFeatureAnnoun($modal_window->id, $modal_slide);
                }
                
                $modal_slide->save();
                header("Location: " . Url::base(true) . '/modal/edit?id=' . $modal_id);
                exit(0);
                //return $this->redirect(['modal/edit', 'id' => $modal_id]);
            } else {
                if (!$valid_image) {
                    $modal_slide->addError('Upload file', 'Allow only images - jpg, png, gif.');
                }

                if (!$valid_related_tutorials) {
                    $modal_slide->addError('Upload file', 'Use image and related tutorial not allowed.');
                }
                
                $errors = array_merge($model->errors, $modal_slide->errors);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'modal_window' => $modal_window,
            'template_params' => $template_params,
            'errors' => $errors
        ]);
    }

    /**
     * Displays edit modal slide page.
     *
     * @return Response|string
     */
    public function actionEdit($id)
    {
        $model = ModalSlide::findOne($id);
        $modal_id = $model->modal_id;
        $modal_window = Modal::findOne($modal_id);
        $template_params = Template::getFormParams($model->template_id);
        $model->template = Template::convertToString($model->template_id);
        $errors = [];

        if (Yii::$app->request->post()) {
            $form_data = Yii::$app->request->post()['ModalSlide'];

            // don't allow make all slides hidden for visible modal
            if ($modal_window->show && $form_data['show'] == 0 && !self::hasVisibleSlides($modal_id, $id)) {
                $model->addError('Visible for users', 'This modal window is visible for user. Please make modal window hidden. Then try again.');
                $errors = $model->errors;
                return $this->render('edit', [
                    'model' => $model,
                    'modal_window' => $modal_window,
                    'template_params' => $template_params,
                    'errors' => $errors
                ]);
            }

            $template_model = new DynamicTemplate($form_data);
        
            // add validate rules for particular template
            $template_model = $this->addTemplateValidateRules($template_model, $model->template_id, $template_params);
            $template_model->validate();
            
            // handle image upload
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $valid_image = self::isImageTypeValid($model);
            
            $model->load(Yii::$app->request->post());
            
            if ($model->validate() && $template_model->validate() && $valid_image) {
                if (!empty($model->imageFile)) {
                    $form_data['file'] = $model->upload();
                }
                //handle default slide params
                $model->name = $form_data['name'];
                $model->show = $form_data['show'];

                // handle params for particular template
                foreach ($template_params as $param_name) {
                    if (isset($form_data[$param_name])) {
                        $model->{$param_name} = $form_data[$param_name];
                    }
                }
                
                //handle feature annoncement logic
                if (!empty($modal_window->feature_announ) && (isset($model->button_modal_id) ||  isset($model->button_product_tour_id))) {
                    FeatureAnnounModalTutorialAssn::handleFeatureAnnoun($modal_window->id, $model);
                }
                
                $model->save();
                header("Location: " . Url::base(true) . '/modal/edit?id=' . $model->modal_id);
                exit(0);
                //return $this->redirect(['modal/edit', 'id'=>$model->modal_id]);
            } else {
                if (!$valid_image) {
                    $template_model->addError('Upload file', 'Allow only images - jpg, png, gif.');
                }
                
                $errors = array_merge($model->errors, $template_model->errors);
            }
        }
        
        return $this->render('edit', [
            'model' => $model,
            'modal_window' => $modal_window,
            'template_params' => $template_params,
            'errors' => $errors
        ]);
    }

    /**
     * Validate image type
     * @param mixed $model
     * @return bool
     */
    public static function isImageTypeValid($model)
    {
        if (!empty($model->imageFile)) {
            return in_array($model->imageFile->type, DynamicTemplate::imageMIMETypes());
        }
        return true;
    }

   /**
    * Check if modal window has at leas one visible slide
    *
    * @param integer $modal_id - id of model for search visible slide
    * @return boolean
    */
    public static function hasVisibleSlides($modal_id, $ignore_slide_id = null)
    {
        $modal_slides = ModalSlide::find()->where(['modal_id' =>$modal_id])->all();

        foreach ($modal_slides as $modal_slide) {
            if ($modal_slide->show) {
                if (is_null($ignore_slide_id) || (!is_null($ignore_slide_id) && $ignore_slide_id != $modal_slide->id)) {
                    return true;
                }
            }
        }
        
        return false;
    }

    /**
     * Add special validate rules by template id
     * @param mixed $model - modal slide model
     * @param mixed $template_id - id of template
     * @param mixed $template_params - template params
     * @return $model - slide model with template validate rules
     */
    public function addTemplateValidateRules($model, $template_id, $template_params)
    {
        $template_name = Template::convertToString($template_id);
        
        /* START define requried fields for each template */

        $required_fields = [];
        // Name required for all slides
        $model->addRule(['name'], 'required');
        $model->addRule(['name'], 'match', ['pattern' => '/^[a-z0-9 ,.\-]+$/i','message'=> 'Only English words allowed']);
        
        // For start slide button text required
        if ($model->type == ModalSlide::MODAL_SLIDE_FIRST_TYPE) {
            $model->addRule(['button_text'], 'required');
            $model->addRule(['button_text'], 'string', ['max' => 30]);
        }
        if ($template_name == 'templateFour') {
            $model->addRule(['button_text'], 'string', ['max' => 30]);
        }
        
        if ($template_name == 'templateNewOne') {
            $required_fields = array_merge($required_fields, ['youtube_link', 'description']);
        }

        /*
        if ( in_array($template_name, ['templateEight', 'templateNine']))
        {
            $required_fields = array_merge($required_fields, ['imageFile']);
        }
        */
        if (in_array($template_name, ['templateFive'])) {
            $required_fields = array_merge($required_fields, ['youtube_link']);
        }
        
        if (!empty($required_fields)) {
            $model->addRule($required_fields, 'required');
        }
        
        // for this template at least one title or content required
        if (in_array($template_name, ['templateSix'])) {
            $model->addRule(['title', 'content'], 'compositerequired', ['params' => ['oneOf'=>['title', 'content'],]]);
        }

        // for this template at least one title or content required
        if (in_array($template_name, ['templateFour']) && isset($model->button_product_tour_id) && isset($model->button_modal_id)) {
            $model->addRule(['button_product_tour_id', 'button_modal_id'], 'onlyOneAllowed', ['params' => ['oneOf'=>['button_product_tour_id', 'button_modal_id'],]]);
        }

        
        if ($model->type == ModalSlide::MODAL_SLIDE_LAST_TYPE && isset($model->related_tutorial_1_text)) {
            $model->addRule(['related_tutorial_1_text', 'file'], 'onlyOneAllowed', ['params' => ['oneOf'=>['related_tutorial_1_text', 'file'],]]);
        }

        if ($model->type == ModalSlide::MODAL_SLIDE_LAST_TYPE && isset($model->related_tutorial_2_text)) {
            $model->addRule(['related_tutorial_2_text', 'file'], 'onlyOneAllowed', ['params' => ['oneOf'=>['related_tutorial_2_text', 'file'],]]);
        }

        if ($model->type == ModalSlide::MODAL_SLIDE_LAST_TYPE && isset($model->related_tutorial_3_text)) {
            $model->addRule(['related_tutorial_3_text', 'file'], 'onlyOneAllowed', ['params' => ['oneOf'=>['related_tutorial_3_text', 'file'],]]);
        }

        if ($model->type == ModalSlide::MODAL_SLIDE_LAST_TYPE && isset($model->related_tutorial_4_text)) {
            $model->addRule(['related_tutorial_4_text', 'file'], 'onlyOneAllowed', ['params' => ['oneOf'=>['related_tutorial_4_text', 'file'],]]);
        }

        if ($model->type == ModalSlide::MODAL_SLIDE_LAST_TYPE) {
            $model->addRule(['related_tutorial_1_text'], 'relatedTutorialRequired', ['params' => ['tutorial_fields'=>['related_tutorial_1_modal_id', 'related_tutorial_1_product_tour_id'],]]);
        }
        if ($model->type == ModalSlide::MODAL_SLIDE_LAST_TYPE) {
            $model->addRule(['related_tutorial_2_text'], 'relatedTutorialRequired', ['params' => ['tutorial_fields'=>['related_tutorial_2_modal_id', 'related_tutorial_2_product_tour_id'],]]);
        }
        if ($model->type == ModalSlide::MODAL_SLIDE_LAST_TYPE) {
            $model->addRule(['related_tutorial_3_text'], 'relatedTutorialRequired', ['params' => ['tutorial_fields'=>['related_tutorial_3_modal_id', 'related_tutorial_3_product_tour_id'],]]);
        }
        if ($model->type == ModalSlide::MODAL_SLIDE_LAST_TYPE) {
            $model->addRule(['related_tutorial_4_text'], 'relatedTutorialRequired', ['params' => ['tutorial_fields'=>['related_tutorial_4_modal_id', 'related_tutorial_4_product_tour_id'],]]);
        }
        
        /* END define required fields for each template */

        /* START define TYPE AND LENGTH fields for each template */

        if (in_array('description', $template_params)) {
            $model->addRule('description', 'string', ['min' => 3]);
        }

        if (in_array('title', $template_params)) {
            $model->addRule('title', 'string', ['max'=>255, 'min' => 3]);
        }

        if ($model->type == ModalSlide::MODAL_SLIDE_LAST_TYPE && in_array('related_tutorial_1_text', $template_params)) {
            $model->addRule('related_tutorial_1_text', 'string', ['max'=>30, 'min' => 3]);
        }

        if ($model->type == ModalSlide::MODAL_SLIDE_LAST_TYPE &&  in_array('related_tutorial_2_text', $template_params)) {
            $model->addRule('related_tutorial_2_text', 'string', ['max'=>30, 'min' => 3]);
        }

        if ($model->type == ModalSlide::MODAL_SLIDE_LAST_TYPE &&  in_array('related_tutorial_3_text', $template_params)) {
            $model->addRule('related_tutorial_3_text', 'string', ['max'=>30, 'min' => 3]);
        }

        if ($model->type == ModalSlide::MODAL_SLIDE_LAST_TYPE && in_array('related_tutorial_4_text', $template_params)) {
            $model->addRule('related_tutorial_4_text', 'string', ['max'=>30, 'min' => 3]);
        }
        /* END define TYPE AND LENGTH fields for each template */

        if ($template_name == 'templateNewOne') {
            $model->addRule('youtube_link', CodeValidator::className());
        }

        if ($template_name == 'templateFive') {
            $model->addRule('youtube_link', CodeValidator::className());
        }

        return $model;
    }

    /**
     * Delete modal slide page.
     *
     * @return Response
     */
    public function actionDelete($id)
    {
        $model = ModalSlide::findOne($id);
        
        if ($model) {
            $model->delete();
        }
        
        header("Location: " . Url::base(true) . '/modal/edit?id=' . $model->modal_id);
        exit(0);
        //return $this->redirect(['modal/edit', 'id'=>$model->modal_id]);
    }

    /**
     * Function for drag and drop AJAX request.
     *
     * @return string json response
     */
    public function actionSort()
    {
        $request = Yii::$app->request;
        
        if ($request->isAjax && $request->post()) {
            $modal_slides = $request->post()['slides'];
            
            foreach ($modal_slides as $order => $modal_slide_id) {
                $model = ModalSlide::findOne($modal_slide_id);
                $model->order = $order;
                $model->save();
            }
            return  \yii\helpers\Json::encode(['success' => true,]);
        }

        return  \yii\helpers\Json::encode(['success' => false]);
    }
}
