<?php

namespace app\modules\api\controllers;

use yii\rest\Controller;
use app\models\ProductTourAdmin;

class ProductTourAdminController extends Controller
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
     * Return flag - show or not show admin button on FE
     *
     * @param string $username - username in Checker system
     * @return array
     */
    public function actionIndex($username)
    {
        $exists = ProductTourAdmin::find()->where(['checker_username' => $username])->all();
        $response = [
            'show' => !empty($exists)
        ];
        return $response;
    }
}
