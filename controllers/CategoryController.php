<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Category;
use app\models\Modal;
use app\models\ProductTour;
use yii\web\UploadedFile;
use yii\helpers\Url;
use app\components\utility\FormatApiResponse;

class CategoryController extends Controller
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
                        'actions' => ['index', 'sort', 'create', 'edit', 'delete', 'tutorials', 'sort-tutorials'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays category list page.
     *
     * @return string
     */
    public function actionIndex()
    {
        $categories = Category::find()->where(['parent' => 0])->orderBy('order')->all();
        
        return $this->render('index', [
            'categories' => $categories
        ]);
    }

    /**
     * Sort category api for drag and drop AJAX request.
     *
     * @return json string
     */
    public function actionSort()
    {
        $request = Yii::$app->request;
        if ($request->isAjax && $request->post()) {
            $categories = $request->post()['categories'];
            foreach ($categories as $order => $category_id) {
                $model = Category::findOne($category_id);
                $model->order = $order;
                $model->save();
            }
            return  \yii\helpers\Json::encode(['success' => true,]);
        }
    }

     /**
     * Displays create category page.
     *
     * @return Response|string
     */
    public function actionCreate()
    {
        $model = new Category();
        if (Yii::$app->request->post()) {
            //TODO: move to choose icon instead of upload image
            $model->iconFile = UploadedFile::getInstance($model, 'iconFile');
            $model->load(Yii::$app->request->post());
            $form_data = Yii::$app->request->post()['Category'];

            if ($model->validate()) {
                if (!empty($model->iconFile)) {
                    $model->icon = $model->upload();
                }
                
                $model->name = $form_data['name'];
                if (empty($form_data['parent'])) {
                    $form_data['parent'] = 0;
                }
                $model->parent = $form_data['parent'];
                
                $model->save();
                header("Location: " . Url::base(true) . '/category');
                exit(0);
                //return $this->redirect(['category/']);
            }
        } else {
            //add default values
            $model->theme = 'theme-1';
            $model->logo_name = 'bookmark_border';
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Displays edit category page.
     *
     * @return Response|string
     */
    public function actionEdit($id)
    {
        $model = Category::findOne($id);
        $sub_categories = Category::find()->where(['parent' => $id])->orderBy('order')->all();
        if (Yii::$app->request->post()) {
            //TODO: move to choose icon instead of upload image
            $model->iconFile = UploadedFile::getInstance($model, 'iconFile');
            if ($model->load(Yii::$app->request->post())) {
                if (!empty($model->iconFile)) {
                    $model->icon = $model->upload();
                }
                    
                $model->name = Yii::$app->request->post()['Category']['name'];
                $model->theme = Yii::$app->request->post()['Category']['theme'];
                $model->logo_name = Yii::$app->request->post()['Category']['logo_name'];
                $model->parent = empty(Yii::$app->request->post()['Category']['parent']) ? 0 :Yii::$app->request->post()['Category']['parent'];
                $model->save();
            }
        }
        
        return $this->render('edit', [
            'model' => $model,
            'sub_categories' => $sub_categories
        ]);
    }

     /**
     * Displays category delete.
     *
     * @return Response|string
     */
    public function actionDelete($id)
    {
        $model = Category::findOne($id);
        
        if (!empty($model)) {
            $model->delete();
            //return $this->redirect(['category/']);
        }
        header("Location: " . Url::base(true) . '/category');
        exit(0);
        //return $this->refresh();
    }

   /**
    *
    * Displays category tutorials page.
    *
    * @param [integer] $id - category id
    * @return void
    */
    public function actionTutorials($id)
    {
        $modals = Modal::find()->select(['id', 'name', 'order', 'show'])->where([ 'category_id' => (int)$id])->asArray()->all();
        $product_tours = ProductTour::find()->select(['id', 'name', 'order', 'show'])->where([ 'category_id' => (int)$id])->asArray()->all();
        
        $category_tutorials = [];
        foreach ($product_tours as $product_tour) {
            $product_tour['type'] = 'product_tour';
            $category_tutorials[] = $product_tour;
        }
        foreach ($modals as $modal) {
            $modal['type'] = 'modal';
            $category_tutorials[] = $modal;
        }
        
        $category_tutorials = FormatApiResponse::sortByOrder($category_tutorials);
        return $this->render('tutorials', [
            'tutorials' => $category_tutorials,
            'category' => Category::findOne($id)
        ]);
    }
     /**
     * Sort category api for drag and drop AJAX request.
     *
     * @return json string
     */
    public function actionSortTutorials()
    {
        $request = Yii::$app->request;
        if ($request->isAjax && $request->post()) {
            $tutorials = $request->post()['tutorials'];
           
            
            foreach ($tutorials as $order => $tutorial) {
                if ($tutorial['type'] === 'modal') {
                    $model = Modal::findOne($tutorial['id']);
                    $model->order = $order;
                    $model->save();
                } else if ($tutorial['type'] === 'product_tour') {
                    $model = ProductTour::findOne($tutorial['id']);
                    $model->order = $order;
                    $model->save();
                }
            }
            
            return  \yii\helpers\Json::encode(['success' => true,]);
        }
    }
}
