<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Category;
use app\models\User;
use creocoder\taggable\TaggableBehavior;

class Modal extends ActiveRecord
{
    public $logoFile;

    const PRIMARY_COLOR = '#4a86e8';
    const SECONDARY_COLOR = '#666666';
    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'modal';
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
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['name'], 'string', 'max' => 255],
            //[['logoFile'], 'file','skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            ['tagValues', 'safe'],
            ['name', 'match', 'pattern' => '/^[a-z0-9 ,.\-]+$/i','message'=> 'Only English words allowed'],
            ['tagValues', 'match', 'pattern' => '/^[a-z0-9 ,.\-]+$/i','message'=> 'Only English words allowed'],
            [['auto_show_start_date'], 'validateAutoShowStartDate'],
            //['auto_show_start_date', 'date', 'format' => 'd-M-Y'],
            
            
        ];
    }
    /**
     * Upload logo function
     *
     * @return boolean|string
     */
    public function upload()
    {
        if ($this->validate()) {
            $this->logoFile->saveAs('uploads/' . $this->logoFile->baseName . '.' . $this->logoFile->extension);
            return 'uploads/' . $this->logoFile->baseName . '.' . $this->logoFile->extension;
        } else {
            return false;
        }
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

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('{{%modal_tag_assn}}', ['modal_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    public function validateAutoShowStartDate($attribute, $params)
    {
        $minAgeDate = time() - 5*31556926;
        $maxAgeDate = time() + 5*31556926;
        
        if (strtotime($this->$attribute) < $minAgeDate) {
            $this->addError($attribute, 'Date is too small.');
        } elseif (strtotime($this->$attribute) > $maxAgeDate) {
            $this->addError($attribute, 'Date is to big.');
        }
    }
}
