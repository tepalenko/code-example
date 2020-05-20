<?php

use yii\db\Migration;

/**
 * Class m200211_134626_add_type_column_tour_steps
 */
class m200211_134626_add_type_column_tour_steps extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_tour_step}}', 'type', 'VARCHAR(255) DEFAULT NULL AFTER `product_tour_id` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200211_134626_add_type_column_tour_steps cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200211_134626_add_type_column_tour_steps cannot be reverted.\n";

        return false;
    }
    */
}
