<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\Tag;
use yii\data\ActiveDataProvider;

class TagController extends ActiveController
{
    public $modelClass = 'app\models\Tag';
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // add CORS filter
        
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];
        
        return $behaviors;
    }
    
    public function actions()
    {
        $actions = parent::actions();
        
        $actions['index'] = [

            'class' => 'yii\rest\IndexAction',
        
            'modelClass' => $this->modelClass,
        
            'prepareDataProvider' => function () {
                return new ActiveDataProvider([
                    'query' =>  Tag::find()
                    ->leftJoin(
                        'modal_tag_assn',
                        'modal_tag_assn.tag_id = tag.id'
                    )->leftJoin(
                        'product_tour_tag_assn',
                        'product_tour_tag_assn.tag_id = tag.id '
                    )->leftJoin(
                        'modal',
                        'modal.id = modal_id'
                    )->leftJoin(
                        'product_tour',
                        'product_tour.id = product_tour_id  '
                    )
                    
                    ->where([
                                'OR',
                                ['product_tour.show' => 1],
                                ['modal.show' => 1]
            
                            ])
                    ->orderBy(['name' => SORT_ASC]),
                    'pagination' => false,
        
                ]);
            }
        ];
        return $actions;
    }
}
