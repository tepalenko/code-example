<?php

use yii\db\Migration;

/**
 * Class m191129_110308_add_show_column_modal_table
 */
class m191129_110308_add_show_column_modal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%modal}}', 'show', 'TINYINT(1) DEFAULT 0 AFTER `name` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191129_110308_add_show_column_modal_table cannot be reverted.\n";

        return false;
    }
}
