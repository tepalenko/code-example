<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%help_center_page}}`.
 */
class m200304_083646_create_help_center_page_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
        if ($this->db->getTableSchema('{{%help_center_page}}', true) !== null) {
            $this->dropTable('{{%help_center_page}}');
        }
        $this->createTable('{{%help_center_page}}', [
            'id' => $this->primaryKey(),
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'slug' => Schema::TYPE_STRING . ' NOT NULL',
            'content' => Schema::TYPE_TEXT . ' DEFAULT NULL',
            'draft' => Schema::TYPE_TEXT . ' DEFAULT NULL',
            'status' => 'TINYINT(1) DEFAULT 0',
            'visibility' => 'TINYINT(1) DEFAULT 0',
            'order' => Schema::TYPE_INTEGER . ' DEFAULT 0',
            'category_id' => Schema::TYPE_INTEGER,
            'updated_at' => $this->timestamp(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `slug`
        $this->createIndex(
            'idx-help_center_page-slug',
            'help_center_page',
            'slug',
            true
        );

        // creates index for column `category_id`
        $this->createIndex(
            'idx-help_center_page-category_id',
            'help_center_page',
            'category_id'
        );

       // add foreign key for table `help_center_category`
        $this->addForeignKey(
            'fk-help_center_page-category_id',
            'help_center_page',
            'category_id',
            'help_center_category',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%help_center_page}}');
    }
}
