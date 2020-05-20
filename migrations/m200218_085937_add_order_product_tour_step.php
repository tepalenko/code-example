<?php

use yii\db\Migration;

/**
 * Class m200218_085937_add_order_product_tour_step
 */
class m200218_085937_add_order_product_tour_step extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_tour_step}}', 'order', 'INT(11) DEFAULT 0 AFTER `path` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200218_085937_add_order_product_tour_step cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200218_085937_add_order_product_tour_step cannot be reverted.\n";

        return false;
    }
    */
}
