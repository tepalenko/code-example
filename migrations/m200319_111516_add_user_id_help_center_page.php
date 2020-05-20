<?php

use yii\db\Migration;

/**
 * Class m200319_111516_add_user_id_help_center_page
 */
class m200319_111516_add_user_id_help_center_page extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%help_center_page}}', 'user_id', 'INT(11) DEFAULT 1 AFTER `category_id` ');

          // creates index for column `page_id`
        $this->createIndex(
            'idx-help-center-page-user_id',
            'help_center_page',
            'user_id'
        );

        // add foreign key for table `help_center_`
        $this->addForeignKey(
            'fk-help_center_page-user_id',
            'help_center_page',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200319_111516_add_user_id_help_center_page cannot be reverted.\n";

        return false;
    }
}
