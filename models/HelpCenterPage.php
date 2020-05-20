<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "help_center_page".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $content
 * @property string|null $draft
 * @property int|null $status
 * @property int|null $show
 * @property int|null $order
 * @property int|null $category_id
 * @property int|null $user_id
 * @property string $updated_at
 * @property string $created_at
 *
 * @property HelpCenterCategory $category
 * @property User $user
 * @property HelpCenterTagAssn[] $helpCenterTagAssns
 * @property HelpCenterTag[] $tags
 */
class HelpCenterPage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'help_center_page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['content', 'draft'], 'string'],
            [['status', 'show', 'order', 'category_id', 'user_id'], 'integer'],
            [['updated_at', 'created_at'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => HelpCenterCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'content' => 'Content',
            'draft' => 'Draft',
            'status' => 'Status',
            'show' => 'Show',
            'order' => 'Order',
            'category_id' => 'Category ID',
            'user_id' => 'User ID',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(HelpCenterCategory::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Gets query for [[HelpCenterTagAssns]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHelpCenterTagAssns()
    {
        // we don't have HelpCenterTagAssn model yet.
        //return $this->hasMany(HelpCenterTagAssn::className(), ['help_center_page_id' => 'id']);
    }

    /**
     * Gets query for [[Tags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(HelpCenterTag::className(), ['id' => 'tag_id'])->viaTable('help_center_tag_assn', ['help_center_page_id' => 'id']);
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
            ],
        ];
    }
}
