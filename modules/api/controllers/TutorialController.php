<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use app\models\Modal;
use app\models\ProductTour;
use app\models\Tag;
use app\components\utility\FormatApiResponse;

class TutorialController extends Controller
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
     * Search tutorials by tag
     *
     * @param string $tags - tags for search separated by comma
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
        
        $response['tutorials'] = [];

        $modals = Modal::find()->where(['show' => true])->anyTagValues($tags_names)->asArray()->all();
        
        foreach ($modals as $modal) {
            $modal['tutorialType'] = 'modal';
            $response['tutorials'][] = $modal;
        }

        $product_tours = ProductTour::find()->where(['show' => true])->anyTagValues($tags_names)->asArray()->all();
        
        foreach ($product_tours as $product_tour) {
            $product_tour['tutorialType'] = 'productTour';
            $response['tutorials'][] = $product_tour;
        }
        
        return $response;
    }
    
    /**
     * Get list of tutorials by category id
     *
     * @param integer $category_id - id of category
     * @return void
     */
    public function actionByCategory($category_id)
    {
        $tutorials = [];
        $modals = Modal::find()->where(['category_id' => $category_id, 'show' => true])->asArray()->all();
        
        foreach ($modals as $modal) {
            $modal['tutorialType'] = 'modal';
            $tutorials[] = $modal;
        }

        $product_tours = ProductTour::find()->where(['category_id' => $category_id, 'show' => true])->asArray()->all();
        
        foreach ($product_tours as $product_tour) {
            $product_tour['tutorialType'] = 'productTour';
            $tutorials[] = $product_tour;
        }
        $tutorials = FormatApiResponse::sortByOrder($tutorials);
        $response['tutorials'] = $tutorials;
        return $response;
    }
}
