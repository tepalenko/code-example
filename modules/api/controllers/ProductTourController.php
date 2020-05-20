<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\ProductTour;
use app\models\ProductTourAdmin;
use app\models\TutorialStats;

class ProductTourController extends ActiveController
{
    public $modelClass = 'app\models\ProductTour';

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
     * Remove action "create" from default rest api behaviour
     *
     * @return void
     */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['index']);
        return $actions;
    }
    /**
     * Create product tour
     *
     * @return void
     */
    public function actionCreate()
    {
        $data= Yii::$app->request->post();
        $model = new ProductTour();
        $model->load($data, '');
        $product_tour_admin = ProductTourAdmin::find()->where(['checker_username' => $data['author']])->one();
        $model->author_id = $product_tour_admin->id;
        if ($model->validate()) {
            $model->save();
        } else {
            //TODO: add error handling
            $errors = $model->errors;
            var_dump($model->errors);
            die;
        }
        return $model;
    }

    /**
     * Get list of all open tutorials by user
     *
     * @return void
     */
    public function actionHistory($unique_user_id)
    {
        $tutorials_query = TutorialStats::find()
        ->select(['*', 'max(tutorial_stats.step) as last_step'])
        ->where(['AND', ['unique_user_id' => $unique_user_id], ['not', ['product_tour_id' => null]],])
        ->orderBy(['create_at' => SORT_DESC])
        ->groupBy('product_tour_id');

        $stats = $tutorials_query->asArray()->all();
        $response = [];
        foreach ($stats as $stat) {
            $product_tour = ProductTour::find()->where(['id' => $stat['product_tour_id']]);
            $tour_data = $product_tour->asArray()->one();
            $steps = ProductTour::findOne($stat['product_tour_id'])->getProductTourSteps()->all();
            $tour_data['last_step'] = $stat['last_step'];
            $tour_data['steps_count'] = sizeof($steps);
            $response[] = $tour_data;
        }
        return $response;
    }

    /**
     * Return list of Visible product tours.
     *
     * @return string
     */
    public function actionList()
    {
        $product_tours = ProductTour::find()->where(['show' => 1])->all();
        
        return $product_tours;
    }
    /**
     * Return list of All product tours.
     *
     * @return string
     */
    public function actionIndex()
    { 
        $product_tours = ProductTour::find()->all();
        
        return $product_tours;
    }
}
