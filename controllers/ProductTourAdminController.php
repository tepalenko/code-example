<?php

namespace app\controllers;

use Yii;
use app\models\ProductTourAdmin;
use yii\filters\VerbFilter;
use app\components\PermissionsHelper;
use yii\filters\AccessControl;
use yii\helpers\Url;

class ProductTourAdminController extends \yii\web\Controller
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
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return PermissionsHelper::requireAdmin();
                        }
                    ],
                ],
                
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Show Product tour admin create page
     *
     * @return void
     */
    public function actionCreate()
    {
        return $this->render('create');
    }

    /**
     * Delete product tour admin.
     * @param number $id - row id from DB
     * @return void
     */
    public function actionDelete($id)
    {
        $model = ProductTourAdmin::findOne($id);
        
        if (!empty($model)) {
            $model->delete();
           
            //return $this->redirect(['product-tour-admin/']);
        }
        header("Location: " . Url::base(true) . '/product-tour-admin');
        exit(0);
        //return $this->refresh();
    }

    /**
     * Show product tour admins and create new one if POST send
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new ProductTourAdmin();
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if ($model->validate()) {
                $model->checker_username = Yii::$app->request->post()['ProductTourAdmin']['checker_username'];
                $model->save();
            }
        }
        $product_tour_admins = ProductTourAdmin::find()->all();
        return $this->render('index', [
            'product_tour_admins' => $product_tour_admins,
            'model' => $model
        ]);
    }
}
