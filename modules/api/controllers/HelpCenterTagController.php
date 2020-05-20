<?php

namespace app\modules\api\controllers;

use Yii;
use app\models\HelpCenterTag;
use app\modules\api\controllers\HelpCenterBaseController;

class HelpCenterTagController extends HelpCenterBaseController
{
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['only'] = ['create'];
        return $behaviors;
    }

    /**
     * Create tag.
     *
     * @return Object Created tag data
     */
    public function actionCreate()
    {
        $model = [];
        $data = Yii::$app->request->post();
        if (isset($data['name'])) {
            $tag['name'] = $data['name'];
            $model = new HelpCenterTag();
            $model->load($tag, '');
            if ($model->validate()) {
                $model->save();
            } else {
                return ['success' => false, 'errors' => $model->errors];
            }
        }
        
        return $model;
    }

    /**
     * List of all tags
     *
     * @return Object List of tags
     */
    public function actionList()
    {
        return HelpCenterTag::find()->all();
    }
}
