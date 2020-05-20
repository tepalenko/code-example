<?php

namespace app\controllers;

use Yii;
use app\models\Tag;
use yii\web\Response;
use yii\web\Controller;

class TagController extends Controller
{
    /**
     * Displays list of tags
     *
     * @return void
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    /**
     * API call for get tag list via AJAX Request
     *
     * @param string $query - query search tag by
     * @return string|JSON
     */
    public function actionList($query = '')
    {
        $likeCondition = new \yii\db\conditions\LikeCondition('name', 'LIKE', $query . '%');
        $likeCondition->setEscapingReplacements(false);
        $tags = Tag::find()->select('name')->where($likeCondition)->asArray()->all();
        
        Yii::$app->response->format = Response::FORMAT_JSON;

        return $tags;
    }
}
