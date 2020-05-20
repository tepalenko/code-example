<?php

use yii\db\Migration;

/**
 * Class m200412_123720_add_position_product_tour_step
 */
class m200412_123720_add_position_product_tour_step extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_tour_step}}', 'position_horizontal', 'VARCHAR(255) DEFAULT "right" AFTER `position` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200412_123720_add_position_product_tour_step cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200412_123720_add_position_product_tour_step cannot be reverted.\n";

        return false;
    }
    */
}
