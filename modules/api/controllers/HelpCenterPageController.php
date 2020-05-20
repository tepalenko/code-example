<?php

namespace app\modules\api\controllers;

use Yii;
use app\models\HelpCenterPage;
use app\models\HelpCenterCategory;
use app\models\HelpCenterTag;
use yii\web\UploadedFile;
use yii\helpers\Url;
use app\modules\api\controllers\HelpCenterBaseController;

class HelpCenterPageController extends HelpCenterBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['only'] = ['create', 'edit', 'delete', 'publish-draft', 'order-list', 'assign-tags'];
        return $behaviors;
    }

    /**
     * List of pages by given category.
     *
     * @param String $category_slug - slug of category
     * @return Array List of pages
     */
    public function actionList($category_slug)
    {
        $category = HelpCenterCategory::find()->where(['slug' => $category_slug])->one();
        $response['pages'] = [];
        if ($category) {
            $pages = HelpCenterPage::find()->where(['category_id' => $category->id])->orderBy('order', 'asc')->all();
            
            foreach ($pages as $page) {
                $response['pages'][] = $this->formatResponse($page);
            }
        }
        
        return $response;
    }

    /**
     * Get one page by slug.
     *
     * @param String $slug - page slug
     * @return Array Page data or error message
     */
    public function actionIndex($slug)
    {
        $page = HelpCenterPage::find()->where(['slug' => $slug])->one();
        if ($page) {
            //TODO: add error handling
            $content = (!empty($page->content)) ? json_decode($page->content, true) : ['blocks' => []];
            $draft = (!empty($page->draft)) ? json_decode($page->draft, true) : ['blocks' => []];
            $user = $page->getUser()->one() ;
            
            $response = [
                'id' => $page->id,
                'name' => $page->name,
                'draft' => $draft,
                'content' => $content,
                'author' => $user->username,
                'update_date' => $page->updated_at
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Page doesn\'t exists'
            ];
        }
        
        return $response;
    }

    /**
     * Create new page
     *
     * @return Array created page data
     */
    public function actionCreate()
    {
        $response = [];
        $data = Yii::$app->request->post();
        if (isset($data['name'])) {
            $page['name'] = $data['name'];
            $category = HelpCenterCategory::find()->where(['slug' => $data['category_slug']])->one();
            $page['category_id'] = $category->id;
            $model = new HelpCenterPage();
            $model->load($page, '');
            if ($model->validate()) {
                $model->save();
                $page = HelpCenterPage::findOne($model->id);
                $response['page'] = $this->formatResponse($page);
            } else {
                $response = ['success' => false, 'errors' => $model->errors];
            }
        } else {
            $response = ['success' => false, 'errors' => 'Required params missed.'];
        }
        
        return $response;
    }

    /**
     * Edit page params.
     *
     * @param Integer $id - page id
     * @return Array Success flag
     */
    public function actionEdit($id)
    {
        $data = Yii::$app->request->post();
        $model = HelpCenterPage::findOne($id);
        if (Yii::$app->request->post()) {
            foreach (['name', 'content', 'status', 'show', 'draft'] as $param) {
                if (isset($data[$param])) {
                    $page[$param] = $data[$param];
                }
            }
            if (!empty($page['draft'])) {
                $page['status'] = 0;
            }
            
            $user = Yii::$app->user->identity;

            $page['user_id'] = $user->id;
            if ($model->load($page, '') && $model->validate()) {
                $model->save();
            } else {
                return ['success' => false, 'errors' => $model->errors];
            }
        }
        return ['success' => true, 'page' => $model];
    }

    /**
     * Delete page.
     *
     * @param Integer $id page id
     * @return Array Success flag
     */
    public function actionDelete($id)
    {
        $page = HelpCenterPage::findOne($id);
        $response['success'] = false;
        if ($page) {
            $response['success'] = true;
            $page->delete();
        }
        return $response;
    }

    /**
     * Search pages by title.
     *
     * @param String $query - query for search
     * @return Object list of pages
     */
    public function actionSearch($query)
    {
        $pages = HelpCenterPage::find()
            ->where(['LIKE', 'title', $query])
            ->andWhere(['show' => 1, 'status' => 1])
            ->all();
        return $pages;
    }

    /**
     * Change page status to 'published' and refill content with draft data.
     *
     * @param Integer $id page id
     * @return Array Success flag and page data
     */
    public function actionPublishDraft($id)
    {
        $model = HelpCenterPage::findOne($id);
        $page['content'] = $model->draft;
        $page['draft'] = '';
        $page['status'] = 1;

        if ($model->load($page, '') && $model->validate()) {
            $model->save();
        } else {
            return ['success' => false, 'errors' => $model->errors];
        }
        
        return ['success' => true, 'page' => $model];
    }

    /**
     * Set order value for each category in "pages" array
     *
     * @return Boolean Always true
     */
    public function actionOrderList()
    {
        $data = Yii::$app->request->post();
        foreach ($data['pages'] as $order => $page) {
            $model = HelpCenterPage::findOne($page['id']);
            $model->order = $order;
            $model->save();
        }
        return true;
    }

    /**
     * Assign tags for page.
     *
     * @param Integer $page_id - page id
     * @return Boolean Always true
     */
    public function actionAssignTags($page_id)
    {
        $data = Yii::$app->request->post();
        if (isset($data['tags'])) {
            //delete all tags assigned to page before save new ones
            Yii::$app->db->createCommand("
            DELETE FROM help_center_tag_assn 
            WHERE help_center_page_id = '$page_id'
            ")->execute();

            foreach ($data['tags'] as $tag) {
                if (isset($tag['name'])) {
                    Yii::$app->db->createCommand()->insert('help_center_tag_assn', [
                        'tag_id' => $tag['id'],
                        'help_center_page_id' => $page_id,
                    ])->execute();
                }
            }
        }

        return true;
    }

    /**
     * List of tags assigned to page
     *
     * @param Integer $page_id - page id
     * @return Array List of tags
     */
    public function actionTags($page_id)
    {
        $tags_query = HelpCenterTag::find()
        ->leftJoin(
            'help_center_tag_assn',
            'help_center_tag_assn.tag_id = help_center_tag.id'
        )
        ->where(['help_center_tag_assn.help_center_page_id' => $page_id])
        ->orderBy(['name' => SORT_ASC]);

        $tags = $tags_query->all();
        return $tags;
    }

    /**
     * Upload file
     *
     * @return Array Success flag and file.url for uploaded file.
     */
    public function actionUploadFile()
    {
        $uploads = UploadedFile::getInstancesByName('image');
        
        if (empty($uploads)) {
            return 'Must upload at least 1 file in uploadfile form-data POST';
        }

        foreach ($uploads as $file) {
            $path = 'uploads/' . $file->name;
            $file->saveAs($path);
        }
        $response['success'] = true;
        $response['file']['url'] = Url::base(true) . '/' . $path;
        return  $response;
    }

    /**
     * Format page data for API response
     *
     * @param Object $page - Page for format
     * @return Array Format page data
     */
    public static function formatResponse($page)
    {
        $has_draft = (!empty($page->draft));
        $format_data = [
            'name' => $page->name,
            'id' => $page->id,
            'slug' => $page->slug,
            'status' => $page->status,
            'show' => $page->show,
            'has_draft' => $has_draft,
            'edit' => false,
            'selected' => false
        ];
        return $format_data;
    }
}
