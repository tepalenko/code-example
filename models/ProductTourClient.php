<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_tour_client".
 *
 * @property int $id
 * @property string $hostname
 * @property string $sub_directory_name
 */
class ProductTourClient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_tour_client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hostname', 'sub_directory_name'], 'required'],
            [['hostname', 'sub_directory_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hostname' => 'Hostname',
            'sub_directory_name' => 'Sub Directory Name',
        ];
    }
}
