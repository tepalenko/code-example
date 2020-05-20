<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use app\models\Modal;
use app\models\Tag;

class ModalController extends Controller
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
     * List of modals
     *
     * @return JSON
     */
    public function actionIndex()
    {
        return Modal::find()->all();
    }

     /**
      * Get one modal window by id
      *
      * @param number $id - modal window id
      * @return void
      */
    public function actionView($id)
    {
        return Modal::findOne($id);
    }

    /**
     * Search modal window by tag
     *
     * @param string $tags
     * @return void
     */
    public function actionSearch($tags)
    {
        $tag_ids = explode(',', $tags);
        
        $tags_objects =Tag::find()->where(['id' => $tag_ids])->all();
        $tags_names = [];
        foreach ($tags_objects as $tag) {
            $tags_names[] = $tag->name;
        }
        
        $modals = Modal::find()->anyTagValues($tags_names)->all();
        
        return $modals;
    }
}
