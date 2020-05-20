<?php

use yii\db\Migration;

/**
 * Class m200313_151745_add_access_token_user_table
 */
class m200313_151745_add_access_token_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'access_token', 'VARCHAR(255) DEFAULT NULL AFTER `auth_key` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200313_151745_add_access_token_user_table cannot be reverted.\n";

        return false;
    }
}
