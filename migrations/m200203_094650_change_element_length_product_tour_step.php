<?php

use yii\db\Migration;

/**
 * Class m200203_094650_change_element_length_product_tour_step
 */
class m200203_094650_change_element_length_product_tour_step extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('product_tour_step', 'element', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200203_094650_change_element_length_product_tour_step cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200203_094650_change_element_length_product_tour_step cannot be reverted.\n";

        return false;
    }
    */
}
