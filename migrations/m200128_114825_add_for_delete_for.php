<?php

use yii\db\Migration;

/**
 * Class m200128_114825_add_for_delete_for
 */
class m200128_114825_add_for_delete_for extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%modal}}', 'for_delete', 'TINYINT(1) DEFAULT 1 AFTER `auto_show_start_date` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200128_114825_add_for_delete_for cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200128_114825_add_for_delete_for cannot be reverted.\n";

        return false;
    }
    */
}
