<?php

namespace app\components;

use app\models\User;

use Yii;

class PermissionsHelper
{
    public static function requireAdmin()
    {
        if (Yii::$app->user->identity->level == User::ADMIN_LEVEL) {
            return true;
        } else {
            return false;
        }
    }
}
