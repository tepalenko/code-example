<?php

use yii\db\Migration;

/**
 * Class m200313_083618_add_visibility_help_center_page_table
 */
class m200313_083618_add_visibility_help_center_page_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%help_center_page}}', 'show', 'TINYINT(1) DEFAULT 0 AFTER `status` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200313_083618_add_visibility_help_center_page_table cannot be reverted.\n";

        return false;
    }
}
