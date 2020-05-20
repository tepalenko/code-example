<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 * @property int $order
 *
 * @property Modal[] $modals
 */
class Category extends \yii\db\ActiveRecord
{
    public $iconFile;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'theme', 'logo_name'], 'required'],
            [['name'], 'unique'],
            [['icon'], 'string'],
            [['order'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['name', 'match', 'pattern' => '/^[a-z0-9 ,.\-]+$/i','message'=> 'Only English words allowed'],
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
            'icon' => 'Icon',
            'order' => 'Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModals()
    {
        return $this->hasMany(Modal::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTours()
    {
        return $this->hasMany(ProductTour::className(), ['category_id' => 'id']);
    }

    /**
     * Add extra field for category object in response.
     *
     * @return void
     */
    public function extraFields()
    {
        return [
            'modals',
            'modal_windows',
        ];
    }
    /**
     * Upload image for category
     *
     * @return void
     */
    public function upload()
    {
        if ($this->validate()) {
            $this->iconFile->saveAs('uploads/' . $this->iconFile->baseName . '.' . $this->iconFile->extension);
            return 'uploads/' . $this->iconFile->baseName . '.' . $this->iconFile->extension;
        } else {
            return false;
        }
    }

    /**
     * List of Material Design Icons
     *
     */
    public static function iconsList()
    {
        $icons = [
            'build',
            'add_shopping_cart',
            'settings_phone',
            'assignment_turned_in',
            'check_circle_outline',
            'theaters',
            'airplay',
            'cached',
            'calendar_today',
            'check_circle',
            'credit_card',
            'dashboard',
            'description',
            'exit_to_app',
            'extension',
            'feedback',
            'grade',
            'group_work',
            'help',
            'help_outline',
            'home',
            'https',
            'info',
            'language',
            'lock',
            'open_in_browser',
            'pageview',
            'payment',
            'perm_identity',
            'record_voice_over',
            'question_answer',
            'redeem',
            'restore_from_trash',
            'shop',
            'shopping_basket',
            'shopping_cart',
            'settings_voice',
            'speaker_notes',
            'stars',
            'supervised_user_circle',
            'system_update_alt',
            'verified_user',
            'add_alert',
            'featured_play_list',
            'queue',
            'video_library',
            'contact_mail',
            'ring_volume',
            'save',
            'devices',
            'widgets',
            'insert_invitation',
        ];
        
        return  $icons;
    }
}
