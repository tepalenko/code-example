<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%help_center_category}}`.
 */
class m200303_145219_create_help_center_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%help_center_category}}', [
            'id' => $this->primaryKey(),
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'slug' => Schema::TYPE_STRING . ' NOT NULL',
            'status' => 'TINYINT(1) DEFAULT 0',
            'order' => Schema::TYPE_INTEGER . ' DEFAULT 0',
            'updated_at' => $this->timestamp(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `slug`
        $this->createIndex(
            'idx-help_center_category-slug',
            'help_center_category',
            'slug',
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%help_center_category}}');
    }
}
