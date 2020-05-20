<?php

use yii\db\Migration;

/**
 * Class m191203_194556_add_order_column_to_modal_slides
 */
class m191203_194556_add_order_column_to_modal_slides extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%modal_slides}}', 'order', 'INT(11) DEFAULT 0 AFTER `show` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191203_194556_add_order_column_to_modal_slides cannot be reverted.\n";

        return false;
    }
}
