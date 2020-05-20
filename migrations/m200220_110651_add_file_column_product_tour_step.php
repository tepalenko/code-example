<?php

use yii\db\Migration;

/**
 * Class m200220_110651_add_file_column_product_tour_step
 */
class m200220_110651_add_file_column_product_tour_step extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_tour_step}}', 'file', 'VARCHAR(2083) DEFAULT NULL AFTER `content` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200220_110651_add_file_column_product_tour_step cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200220_110651_add_file_column_product_tour_step cannot be reverted.\n";

        return false;
    }
    */
}
