<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_tour_admin".
 *
 * @property int $id
 * @property string $checker_username
 */
class ProductTourAdmin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_tour_admin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['checker_username'], 'required'],
            [['checker_username'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'checker_username' => 'Checker Username',
        ];
    }
}
