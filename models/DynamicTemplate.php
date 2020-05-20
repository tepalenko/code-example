<?php

namespace app\models;

use Yii;
use yii\base\DynamicModel;

class DynamicTemplate extends DynamicModel
{
    /**
     * Validator: Requires a combination of attributes
     *
     * One of the attributes specified in 'oneOf' param must not be empty
     */
    public function compositerequired($attr, $params)
    {
        $valid=false;
        foreach ($params['oneOf'] as $required) {
            if ($this->$required !== null && trim($this->$required) !== '') {
                $valid = true;
            }
        }
        
        if (!$valid) {
            $this->addError($attr, $params['message']);
            foreach ($params['oneOf'] as $required) {
                $this->addError($required, '');
            }
        }
    }

    /**
     * Validator: Only one of two can be filled
     *
     * One of the attributes specified in 'oneOf' param must not be empty
     */
    public function onlyOneAllowed($attr, $params)
    {
        
        
        $exist_params = [];
        foreach ($params['oneOf'] as $param_name) {
            if (isset($this->$param_name) && $this->$param_name !== null && trim($this->$param_name) !== '') {
                $exist_params[] = $param_name;
            }
        }
        
        if (sizeof($exist_params) > 1) {
            $this->addError($attr, 'You can fill only one of those fields: ' . implode(', ', $params['oneOf']));
        }
    }

    /**
     * List of image MIME Types
     * @return array
     */
    public static function imageMIMETypes()
    {
        return [
            'image/gif',
            'image/jpeg',
            'image/tiff',
            'image/bmp',
            'image/pipeg',
            'image/png',
        ];
    }

    /**
     * Validator: If related tutorial text filled - related tutorial required
     *
     * If related text not empty - related tutorial should be filled too
     *
     */
    public function relatedTutorialRequired($attr, $params)
    {
        $exist_params = [];
        foreach ($params['tutorial_fields'] as $param_name) {
            if (isset($this->$param_name) && $this->$param_name !== null && trim($this->$param_name) !== '') {
                $exist_params[] = $param_name;
            }
        }
        
        if (sizeof($exist_params) !== 1) {
            $this->addError($attr, 'You have to attach tutorial when you use tutorial text: ' . implode(', ', $params['tutorial_fields']));
        }
    }
}
