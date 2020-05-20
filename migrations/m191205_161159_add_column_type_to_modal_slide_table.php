<?php

use yii\db\Migration;

/**
 * Class m191205_161159_add_column_type_to_modal_slide_table
 */
class m191205_161159_add_column_type_to_modal_slide_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%modal_slides}}', 'type', 'TINYINT(2) DEFAULT 0 AFTER `show` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191205_161159_add_column_type_to_modal_slide_table cannot be reverted.\n";

        return false;
    }
}
