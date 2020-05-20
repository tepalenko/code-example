<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m191106_162914_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'icon' => Schema::TYPE_TEXT . ' DEFAULT NULL',
            'order' => Schema::TYPE_INTEGER . ' DEFAULT 0',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }
}
