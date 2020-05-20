<?php

use yii\db\Migration;

/**
 * Class m191111_113929_add_show_flag_to_slides_table
 */
class m191111_113929_add_show_flag_to_slides_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%modal_slides}}', 'show', 'TINYINT(1) DEFAULT 0 AFTER `name` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191111_113929_add_show_flag_to_slides_table cannot be reverted.\n";

        return false;
    }
}
