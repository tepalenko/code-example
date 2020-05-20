<?php

use yii\db\Migration;

/**
 * Class m200124_140407_add_hostpot_column_to_tutorial_stats
 */
class m200124_140407_add_hostpot_column_to_tutorial_stats extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tutorial_stats}}', 'show_hostpot', 'TINYINT(1) DEFAULT 0 AFTER `show_welcome_message` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200124_140407_add_hostpot_column_to_tutorial_stats cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200124_140407_add_hostpot_column_to_tutorial_stats cannot be reverted.\n";

        return false;
    }
    */
}
