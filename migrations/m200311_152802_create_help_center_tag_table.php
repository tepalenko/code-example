<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%help_center_tag}}`.
 */
class m200311_152802_create_help_center_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%help_center_tag}}', [
            'id' => $this->primaryKey(),
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'frequency' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%help_center_tag}}');
    }
}
