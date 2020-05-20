<?php

namespace app\modules\api\controllers;

use Yii;

use app\models\HelpCenterPage;
use app\models\HelpCenterCategory;
use app\modules\api\controllers\HelpCenterBaseController;

class HelpCenterCategoryController extends HelpCenterBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['only'] = ['create', 'edit', 'delete', 'order-list'];

        return $behaviors;
    }

    /**
     * Get all categories.
     *
     * @return Array List of categories
     */
    public function actionList()
    {
        $categories = HelpCenterCategory::find()->orderBy('order')->all();
        $response['categories'] = [];
        foreach ($categories as $category) {
            $response['categories'][] =[
                'name' => $category->name,
                'id' => $category->id,
                'slug' => $category->slug,
                'status' => $category->status,
                'edit' => false,
                'selected' => false
            ];
        }

        return $response;
    }

    /**
     * Create new category
     *
     * @return Object Created category
     */
    public function actionCreate()
    {
        $model = [];
        $data = Yii::$app->request->post();
        if (isset($data['name'])) {
            $page['name'] = $data['name'];
            $model = new HelpCenterCategory();
            $model->load($page, '');
            if ($model->validate()) {
                $model->save();
            } else {
                return ['success' => false, 'errors' => $model->errors];
            }
        }

        return $model;
    }

    /**
     * Edit category params.
     *
     * @param integer $id - category id
     * @return Array Success flag
     */
    public function actionEdit($id)
    {
        $data = Yii::$app->request->post();
        $model = HelpCenterCategory::findOne($id);
        $model_data = [];
        
        if (Yii::$app->request->post()) {
            if (!empty($data['status']) && empty($data['force'])) {
                $category_pages = HelpCenterPage::find()->where(['category_id' => $id])->all();
                $has_visible_page = false;
                foreach ($category_pages as $page) {
                    if ($page->show == 1) {
                        $has_visible_page = true;
                        break;
                    }
                }
                if (!$has_visible_page) {
                    return ['success' => false];
                }
            }

            foreach (['name', 'status'] as $param) {
                if (isset($data[$param])) {
                    $model_data[$param] = $data[$param];
                }
            }
            
            if ($model->load($model_data, '') && $model->validate()) {
                $model->save();
            } else {
                return ['success' => false, 'errors' => $model->errors];
            }
        }
        return ['success' => true];
    }

    /**
     * Delete category.
     *
     * @param integer $id
     * @return Array Success flag.
     */
    public function actionDelete($id)
    {
        $category = HelpCenterCategory::findOne($id);
        $response['success'] = false;
        if ($category) {
            $pages = HelpCenterPage::find()->where(['category_id' => $id])->all();
            
            if (sizeof($pages) == 0) {
                $response['success'] = true;
                $category->delete();
            }
        }
        return $response;
    }

    /**
     * Set order value for each category in "categories" array
     *
     * @return Boolean Always true
     */
    public function actionOrderList()
    {
        $data = Yii::$app->request->post();
        foreach ($data['categories'] as $order => $page) {
            $model = HelpCenterCategory::findOne($page['id']);
            $model->order = $order;
            $model->save();
        }
        return true;
    }
}
