<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Category;
use app\models\ProductTourAdmin;
use creocoder\taggable\TaggableBehavior;

/**
 * This is the model class for table "product_tour".
 *
 * @property int $id
 * @property string $name
 * @property int $show
 * @property int $category_id
 *
 * @property ProductTourStep[] $productTourSteps
 */
class ProductTour extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_tour';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['author_id'], 'required'],
            [['show', 'category_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['tagValues', 'safe'],
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
            'show' => 'Show',
            'category_id' => 'Category ID',
        ];
    }

    public function behaviors()
    {
        return [
            'taggable' => [
                'class' => TaggableBehavior::className(),
                // 'tagValuesAsArray' => false,
                // 'tagRelation' => 'tags',
                // 'tagValueAttribute' => 'name',
                // 'tagFrequencyAttribute' => 'frequency',
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTourSteps()
    {
        return $this->hasMany(ProductTourStep::className(), ['product_tour_id' => 'id']);
    }

    /**
     * Add extra field to model
     *
     * @return void
     */
    public function extraFields()
    {
        return [
            'productTourSteps'
        ];
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new ModalQuery(get_called_class());
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('{{%product_tour_tag_assn}}', ['product_tour_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTourAdmin()
    {
        return $this->hasOne(ProductTourAdmin::className(), ['id' => 'author_id']);
    }
}
