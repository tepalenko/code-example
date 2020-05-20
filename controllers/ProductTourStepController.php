<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\ProductTourStep;
use yii\helpers\Url;

class ProductTourStepController extends Controller
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
                        'actions' => ['index', 'delete', 'edit', 'fixpath', 'fixelement'],
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
     * Displays edit product tour step page.
     *
     * @param number $id - id of product tour step
     * @return void
     */
    public function actionEdit($id)
    {
        $model = ProductTourStep::findOne($id);
        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post())) {
                $model->save();
            }
            header("Location: " . Url::base(true) . '/product-tour/edit?id=' . $id);
            exit(0);
            //return $this->refresh();
        }
        
        return $this->render('edit', [
            'model' => $model
        ]);
    }

     /**
     * Delete product tour step.
     *
     * @param number $id - id of product tour step
     * @return void
     */
    public function actionDelete($id)
    {
        $model = ProductTourStep::findOne($id);
        
        if (!empty($model)) {
            $model->delete();
            
            //return $this->redirect(['product-tour/edit', 'id' => $model->product_tour_id]);
        }
        header("Location: " . Url::base(true) . '/product-tour/edit?id=' . $id);
        exit(0);
        //return $this->refresh();
    }

    public function actionFixpath()
    {
        $steps = ProductTourStep::find()->all();
        $paths = [];
        foreach ($steps as $step) {
            $step->path = str_replace('/testing', '', $step->path);
            $paths[] = $step->path;
            $step->save();
        }
       
        var_dump($paths);die;
    }
    public function actionFixelement()
    {
        $steps = ProductTourStep::find()->all();
        $elements = [];
        foreach ($steps as $step) {
            
            if (strpos($step->element, 'body>main>') !== false) {
                $step->element = str_replace('body>main>', 'body>div#container>table#width_limiter>tbody>tr>td#the_cell_with_the_program>table#side_menu>tbody>tr>td:eq(2)>', $step->element);
                $elements[] = $step->element;
                $step->save();
            }
        }
        var_dump($elements);die;
    }
}
