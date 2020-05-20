<?php

namespace app\controllers;

use yii\base\Controller;
use yii\helpers\Url;

class UploadController extends Controller
{
   /**
     * Upload image endpoint for html editor in admin panel.
     *
     * @return string|JSON
     *
     */
    public function actionIndex()
    {
        $upload_dir = 'uploads/';
        $upload_dir = $upload_dir . basename($_FILES['upload']['name']);

        $response = [];
        if (move_uploaded_file($_FILES['upload']['tmp_name'], $upload_dir)) {
            $response = [
                'uploaded' => true,
                'url' => Url::base(true) . '/' . $upload_dir
            ];
        } else {
            $response = [
                'uploaded' => false,
                'error' => [
                    'message' => 'could not upload this image'
                ]
            ];
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $response;
    }
}
