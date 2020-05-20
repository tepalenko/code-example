<?php

namespace app\modules\api\controllers;

use app\models\CategorySearch;
use yii\rest\ActiveController;
use app\models\Category;
use app\components\utility\FormatApiResponse;

class CategoryController extends ActiveController
{
    public $modelClass = 'app\models\Category';
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
        //use this one if category by name search needed
        //$actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        unset($actions['index']);
        return $actions;
    }

    /**
     * Add search for category object
     *
     * @return void
     */
    public function prepareDataProvider()
    {
        $search = new CategorySearch();
        return $search->search(\Yii::$app->request->getQueryParams());
    }

    /**
     * Gel list of categories with tutorials inside
     *
     * @return Array
     */
    public function actionIndex()
    {
        $response = [];
        $categories = Category::find()->where(['parent' => 0])->orderBy(['order' => SORT_ASC])->all();

        foreach ($categories as $category) {
            $category_data = self::formatResponse($category->toArray());
            $sub_categories = Category::find()->where(['parent' => $category->id])->orderBy(['order' => SORT_ASC])->all();
            if (!empty($sub_categories)) {
                foreach ($sub_categories as $sub_category) {
                    $sub_category_data = self::formatResponse($sub_category->toArray());
                    $sub_category_tutorials = $this->getCategoryTutorials($sub_category);
                    if (!empty($sub_category_tutorials)) {
                        $sub_category_data['tutorials'] = $sub_category_tutorials;
                        $category_data['sub_categories'][] = $sub_category_data;
                    }
                }
                if (!empty($category_data['sub_categories'])) {
                    $response[] = $category_data;
                }
            } else {
                $category_tutorials = $this->getCategoryTutorials($category);
                if (!empty($category_tutorials)) {
                    $category_data['tutorials'] = $category_tutorials;
                    $response[] = $category_data;
                }
            }
        }
        return $response;
    }

    /**
     * Format response for FE
     *
     * @param object $data - response data
     * @return Array
     */
    public static function formatResponse($data)
    {
        foreach ($data as $key => $value) {
            // add host to file path
            if (in_array($key, ['icon'])) {
                $data[$key] = FormatApiResponse::addHost($data[$key]);
            }
        }

        return $data;
    }

    public static function getCategoryTutorials($category) {
        $tutorials = [];
        $modals = $category->getModals()->where(['show' => true])->asArray()->all();
        foreach ($modals as $modal) {
            $modal['tutorialType'] = 'modal';
            $tutorials[] = $modal;
        }
            
        $product_tours = $category->getProductTours()->where(['show' => true])->asArray()->all();
        foreach ($product_tours as $product_tour) {
            $product_tour['tutorialType'] = 'productTour';
            $tutorials[] = $product_tour;
        }
        return $tutorials;
    }
}
