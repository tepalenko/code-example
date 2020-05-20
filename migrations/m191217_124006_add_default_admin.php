<?php

use yii\db\Migration;
use app\models\User;

/**
 * Class m191217_124006_add_default_admin
 */
class m191217_124006_add_default_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $transaction = $this->getDb()->beginTransaction();
        $user = \Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'create',
            'username' => 'admin_user',
            'password' => 'd033e22ae348aeb5660fc2140aec35850c4da997',
            'level'    => 10,
            'auth_key' => 'default_key',
            'created_at' => time(),
            'updated_at' => 0
        ]);
        if (!$user->insert(false)) {
            $transaction->rollBack();
            return false;
        }
        //$user->confirm();
        $transaction->commit();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191217_124006_add_default_admin cannot be reverted.\n";

        return false;
    }
}
