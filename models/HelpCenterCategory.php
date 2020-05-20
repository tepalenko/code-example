<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "help_center_category".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $status
 * @property int|null $order
 * @property string $updated_at
 * @property string $created_at
 *
 * @property HelpCenterPage[] $helpCenterPages
 */
class HelpCenterCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'help_center_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['status', 'order'], 'integer'],
            [['updated_at', 'created_at'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
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
            'status' => 'Status',
            'order' => 'Order',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[HelpCenterPages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHelpCenterPages()
    {
        return $this->hasMany(HelpCenterPage::className(), ['category_id' => 'id']);
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
