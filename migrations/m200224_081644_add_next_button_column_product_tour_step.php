<?php

use yii\db\Migration;

/**
 * Class m200224_081644_add_next_button_column_product_tour_step
 */
class m200224_081644_add_next_button_column_product_tour_step extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_tour_step}}', 'show_next_button', 'TINYINT(1) DEFAULT 0 AFTER `content` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200224_081644_add_next_button_column_product_tour_step cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200224_081644_add_next_button_column_product_tour_step cannot be reverted.\n";

        return false;
    }
    */
}
