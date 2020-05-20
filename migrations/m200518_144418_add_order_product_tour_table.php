<?php

use yii\db\Migration;

/**
 * Class m200518_144418_add_order_product_tour_table
 */
class m200518_144418_add_order_product_tour_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_tour}}', 'order', 'INT(11) DEFAULT 0 AFTER `name` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200518_144418_add_order_product_tour_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200518_144418_add_order_product_tour_table cannot be reverted.\n";

        return false;
    }
    */
}
