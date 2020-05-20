<?php

namespace app\models;

use Yii;
use yii\base\Security;
use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    const ADMIN_LEVEL = 100;
    const CONTENT_MANAGER_LEVEL = 60;

    public static function tableName()
    {
        return 'user';
    }

     /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'auth_key', 'level',], 'required'],
            [[ 'created_at', 'updated_at'], 'integer'],
            [['username', 'password', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

     /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
            'level' => 'Level',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // find user with token
        if ($user = static::findOne(['access_token' => $token])) {
            return $user->isAccessTokenValid() ? $user : null;
        }
        return null;
    }

    public function generateAccessToken($expireInSeconds)
    {
        $this->access_token = Yii::$app->security->generateRandomString() . '_' . (time() + $expireInSeconds);
    }

    public function isAccessTokenValid()
    {
        if (!empty($this->access_token)) {
            $timestamp = (int) substr($this->access_token, strrpos($this->access_token, '_') + 1);
            return $timestamp > time();
        }
        return false;
    }
    
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === sha1($password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = sha1($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->getSecurity()->generateRandomKey() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Return user name
     */
    public function getUserName()
    {
        return $this->username;
    }

    /**
     * Get list of existed user levels
     *
     * @return array
     */
    public static function getUserLevels()
    {
        return [
            self::ADMIN_LEVEL => 'admin',
            self::CONTENT_MANAGER_LEVEL => 'manager'
        ];
    }
}
