<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\ProductTour;
use app\models\ProductTourStep;
use yii\helpers\Url;

class ProductTourController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'delete', 'edit'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Displays list of product tours.
     *
     * @return string
     */
    public function actionIndex()
    {
        $product_tours = ProductTour::find()->all();
        
        return $this->render('index', [
            'product_tours' => $product_tours,
        ]);
    }

    /**
     * Displays edit product tour page.
     *
     * @param number $id - id for product tour
     *
     * @return void
     */
    public function actionEdit($id)
    {
        $model = ProductTour::findOne($id);
        $product_tour_steps = ProductTourStep::find()->where(['product_tour_id' => $id])->all();
        
        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post())) {
                $model->name = Yii::$app->request->post()['ProductTour']['name'];
                $model->category_id = Yii::$app->request->post()['ProductTour']['category_id'];
                $model->save();
            }
            header("Location: " . Url::base(true) . '/product-tour/edit?id=' . $id);
            exit(0);
            //return $this->refresh();
        }
        
        return $this->render('edit', [
            'model' => $model,
            'product_tour_steps' => $product_tour_steps
        ]);
    }

     /**
     * Delete product tour.
     *
     * @param number $id - id of Product tour
     * @return void
     */
    public function actionDelete($id)
    {
        $model = ProductTour::findOne($id);
        
        if (!empty($model)) {
            $model->delete();
            //return $this->redirect(['product-tour/']);
        }
        header("Location: " . Url::base(true) . '/product-tour');
        exit(0);
        //return $this->refresh();
    }
}
