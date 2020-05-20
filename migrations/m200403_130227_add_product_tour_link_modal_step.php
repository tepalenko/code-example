<?php

use yii\db\Migration;

/**
 * Class m200403_130227_add_product_tour_link_modal_step
 */
class m200403_130227_add_product_tour_link_modal_step extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_tour_step}}', 'redirect_tour_name', 'VARCHAR(1024) DEFAULT NULL AFTER `content` ');
        $this->addColumn('{{%product_tour_step}}', 'redirect_tour', 'VARCHAR(255) DEFAULT NULL AFTER `redirect_tour_name` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200403_130227_add_product_tour_link_modal_step cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200403_130227_add_product_tour_link_modal_step cannot be reverted.\n";

        return false;
    }
    */
}
