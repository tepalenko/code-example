<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use app\models\ProductTourStep;
use app\models\ProductTour;
use app\models\ProductTourClient;

class ProductTourStepsController extends Controller
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
     * Create product tour step
     *
     * @return void
     */
    public function actionCreate($hostname = null)
    {
        $data= Yii::$app->request->post();
        
        ProductTourStep::deleteAll(['product_tour_id' => $data['tour_id']]);
        $client_sub_directory_name = false;
        if (!is_null($hostname)) {
            $product_tour_client = ProductTourClient::find()->where(['hostname' => $hostname])->one();
            if (!empty($product_tour_client)) {
                $client_sub_directory_name = $product_tour_client->sub_directory_name;
            }
        }
        if (!empty($data['steps'])) {
            foreach ($data['steps'] as $step) {
                $step['product_tour_id'] = $data['tour_id'];
                if ($client_sub_directory_name) {
                    $step['path'] = str_replace('/' . $client_sub_directory_name, '', $step['path']);
                }
                $model = new ProductTourStep();
                $model->load($step, '');
                
                if ($model->validate()) {
                    $model->save();
                } else {
                    //TODO: add error handling
                    $errors = $model->errors;
                    var_dump($model->errors);
                    die;
                }
            }
        }
        
        return true;
    }

    /**
     * Update ordering
     *
     * @return void
     */
    public function actionSort()
    {
        $data= Yii::$app->request->post();
        
        if (!empty($data['steps'])) {
            foreach ($data['steps'] as $step) {
                $product_tour_step = ProductTourStep::findOne($step['stepId']);
                $product_tour_step->order = $step['index'];
                $product_tour_step->save();
            }
        }
        
        return true;
    }

    /**
     * List of steps by product tour id
     *
     * @param [integer] $product_tour_id
     * @param [string] $hostname
     * @return void
     */
    public function actionIndex($product_tour_id, $hostname = null)
    {
        $product_steps = ProductTourStep::find()->where(['product_tour_id' => $product_tour_id])->orderBy('order')->asArray()->all();
        
        if (!is_null($hostname)) {
            $product_tour_client = ProductTourClient::find()->where(['hostname' => $hostname])->one();
            if (!empty($product_tour_client)) {
                foreach ($product_steps as $key => $product_step) {
                    $product_steps[$key]['path'] = '/' . $product_tour_client->sub_directory_name . $product_step['path'];
                }
            }
        }
        
        $response = [
            'steps' => $product_steps,
            'product_tour' => ProductTour::find()->where(['id' => $product_tour_id])->one()
        ];
        return $response;
    }
}
