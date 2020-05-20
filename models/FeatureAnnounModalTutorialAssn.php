<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feature_announ_modal_tutorial_assn".
 *
 * @property int $id
 * @property int $feature_announ_modal_id
 * @property int $modal_id
 * @property int $product_tour_id
 *
 * @property Modal $featureAnnounModal
 * @property Modal $modal
 * @property ProductTour $productTour
 */
class FeatureAnnounModalTutorialAssn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feature_announ_modal_tutorial_assn';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['feature_announ_modal_id', 'modal_id', 'product_tour_id'], 'integer'],
            [['feature_announ_modal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Modal::className(), 'targetAttribute' => ['feature_announ_modal_id' => 'id']],
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
            'feature_announ_modal_id' => 'Feature Announ Modal ID',
            'modal_id' => 'Modal ID',
            'product_tour_id' => 'Product Tour ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeatureAnnounModal()
    {
        return $this->hasOne(Modal::className(), ['id' => 'feature_announ_modal_id']);
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

     /**
     * Function for handle modal windows feature announ logic
     * @param mixed $modal_id - model of modal window
     * @param mixed $slide_model - model of slide
     * @return void
     */
    public static function handleFeatureAnnoun($modal_id, $slide_model)
    {
        self::deleteAll(['feature_announ_modal_id' => $modal_id]);
        $model = new self();
        $model->feature_announ_modal_id = $modal_id;
        
        if (isset($slide_model->button_modal_id)) {
            $model->modal_id = $slide_model->button_modal_id;
        }
        
        if (isset($slide_model->button_product_tour_id)) {
            $model->product_tour_id = $slide_model->button_product_tour_id;
        }
            
        if ($model->validate()) {
            $model->save();
        }
    }
}
