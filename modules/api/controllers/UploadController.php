<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\UploadedFile;
use yii\helpers\Url;

class UploadController extends Controller
{
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
     * List of modals
     *
     * @return JSON
     */
    public function actionIndex()
    {
        
        $uploads = UploadedFile::getInstancesByName('file');
        if (empty($uploads)) {
            return 'Must upload at least 1 file in upfile form-data POST';
        }

        foreach ($uploads as $file) {
            $path = 'uploads/' . $file->name;
            $file->saveAs($path);
        }
        $response['path'] = Url::base(true) . '/' . $path;
        return  $response;
    }
}
