<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%help_center_tag_assn}}`.
 */
class m200311_155351_create_help_center_tag_assn_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%help_center_tag_assn}}', [
            'help_center_page_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'tag_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
        
        $this->addPrimaryKey('', '{{%help_center_tag_assn}}', ['help_center_page_id', 'tag_id']);

        // creates index for column `help_center_page_id`
        $this->createIndex(
            'idx-help-center-tag-assn-help_center_page_id',
            'help_center_tag_assn',
            'help_center_page_id'
        );

        // add foreign key for table `help_center_page`
        $this->addForeignKey(
            'fk-help_center_page-help_center_page_id',
            'help_center_tag_assn',
            'help_center_page_id',
            'help_center_page',
            'id',
            'CASCADE'
        );

        // creates index for column `tag_id`
        $this->createIndex(
            'idx-help-center-tag-assn-tag_id',
            'help_center_tag_assn',
            'tag_id'
        );

        // add foreign key for table `help_center_tag`
        $this->addForeignKey(
            'fk-help_center_page-tag_id',
            'help_center_tag_assn',
            'tag_id',
            'help_center_tag',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%help_center_tag_assn}}');
    }
}
