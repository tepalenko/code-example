<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Template;

class ModalSlide extends ActiveRecord
{
    const MODAL_SLIDE_REGULAR_TYPE = 0;
    const MODAL_SLIDE_FIRST_TYPE = 1;
    const MODAL_SLIDE_LAST_TYPE = 2;

    public $imageFile;
    public $additional_fields;
    public function __construct($params = [])
    {
        parent::__construct();
        $this->additional_fields = $params;
    }
    
    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'modal_slides';
    }

    /**
     * @var UploadedFile
     */
    public function rules()
    {
        return [];
    }

    /**
     * Add additional attributes to model
     *
     * @return object
     */
    public function attributes()
    {
        $attributes = parent::attributes();
        foreach ($this->additional_fields as $attribute) {
            $attributes[] = $attribute;
        }
        return $attributes;
    }

    /**
     * Upload modal slide file
     *
     * @return void
     */
    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return 'uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
        } else {
            return false;
        }
    }

    /**
     * Add template params to model
     *
     * @return void
     */
    public function afterFind()
    {
        parent::afterFind();
        
        $template_params = Template::getFormParams($this->template_id);
        $this->additional_fields = $template_params;
        $this->attributes();
        $slide_params = json_decode($this->slide_params, true);
        foreach ($slide_params as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * Remove template params before save model
     *
     * @param model $insert
     * @return void
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $slide_params = [];
            foreach ($this->additional_fields as $attribute) {
                if (isset($this->{$attribute})) {
                    $slide_params[$attribute] = $this->{$attribute};
                    unset($this->{$attribute});
                }
            }

            if ($slide_params) {
                $this->slide_params = json_encode($slide_params);
            }
            
            return true;
        }

        return false;
    }

    /**
     * List of modal slide types
     *
     * @return array
     */
    public static function modalSlideTypes()
    {
        return [
            self::MODAL_SLIDE_REGULAR_TYPE => 'Regular',
            self::MODAL_SLIDE_FIRST_TYPE => 'First slide',
            self::MODAL_SLIDE_LAST_TYPE => 'Last slide',
        ];
    }

    /**
     * Format slide for FE view
     *
     * @param object $slides
     * @return void
     */
    public static function formatSlides($slides)
    {
        $response = (object) [];
        foreach ($slides as $slide) {
            switch ($slide->type) {
                case 0:
                default:
                    $response->slides[] = $slide;
                    break;
                case 1:
                    $response->start_slide = $slide;
                    break;
                case 2:
                    $response->end_slide = $slide;
                    break;
            }
        }
        
        return $response;
    }
}
