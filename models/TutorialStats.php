<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tutorial_stats".
 *
 * @property int $id
 * @property string $unique_user_id
 * @property int $modal_id
 * @property int $product_tour_id
 * @property int $step
 * @property string $create_at
 *
 * @property Modal $modal
 * @property ProductTour $productTour
 */
class TutorialStats extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tutorial_stats';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['unique_user_id'], 'string'],
            [['modal_id', 'product_tour_id', 'step', 'show_welcome_message', 'show_hostpot'], 'integer'],
            [['create_at'], 'safe'],
            [['modal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Modal::className(), 'targetAttribute' => ['modal_id' => 'id']],
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
            'unique_user_id' => 'Unique User ID',
            'modal_id' => 'Modal ID',
            'product_tour_id' => 'Product Tour ID',
            'step' => 'Step',
            'create_at' => 'Create At',
            'show_welcome_message' => 'Show Welcome message'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModal()
    {
        return $this->hasOne(Modal::className(), ['id' => 'modal_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTour()
    {
        return $this->hasOne(ProductTour::className(), ['id' => 'product_tour_id']);
    }
}
