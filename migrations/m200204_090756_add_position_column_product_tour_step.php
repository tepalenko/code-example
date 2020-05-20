<?php

use yii\db\Migration;

/**
 * Class m200204_090756_add_position_column_product_tour_step
 */
class m200204_090756_add_position_column_product_tour_step extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_tour_step}}', 'position', 'VARCHAR(255) DEFAULT NULL AFTER `product_tour_id` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200204_090756_add_position_column_product_tour_step cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200204_090756_add_position_column_product_tour_step cannot be reverted.\n";

        return false;
    }
    */
}
