<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_tour_step".
 *
 * @property int $id
 * @property int $product_tour_id
 * @property string $element
 * @property string $name
 * @property string $content
 * @property string $action
 * @property string $path
 *
 * @property ProductTour $productTour
 */
class ProductTourStep extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_tour_step';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_tour_id'], 'integer'],
            [['name', 'element', 'action', 'path', 'position', 'position_horizontal'], 'required'],
            [['content', 'type', 'file', 'redirect_tour_name'], 'string'],
            [['show_next_button', 'redirect_tour'], 'integer'],
            [['name', 'action', 'path'], 'string', 'max' => 255],
            [['product_tour_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductTour::className(), 'targetAttribute' => ['product_tour_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_tour_id' => 'Product Tour ID',
            'element' => 'Element',
            'name' => 'Name',
            'content' => 'Content',
            'action' => 'Action',
            'path' => 'Path',
            'redirect_tour_name' => 'Redirect tour name',
            'redirect_tour' => 'Redirect tour id'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTour()
    {
        return $this->hasOne(ProductTour::className(), ['id' => 'product_tour_id']);
    }
}
