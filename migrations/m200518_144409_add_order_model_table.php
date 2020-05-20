<?php

use yii\db\Migration;

/**
 * Class m200518_144409_add_order_model_table
 */
class m200518_144409_add_order_model_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%modal}}', 'order', 'INT(11) DEFAULT 0 AFTER `name` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200518_144409_add_order_model_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200518_144409_add_order_model_table cannot be reverted.\n";

        return false;
    }
    */
}
