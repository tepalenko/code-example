<?php

use yii\db\Migration;

/**
 * Class m200115_145124_add_column_welcome_message_to_stats
 */
class m200115_145124_add_column_welcome_message_to_stats extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tutorial_stats}}', 'show_welcome_message', 'TINYINT(1) DEFAULT 0 AFTER `unique_user_id` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200115_145124_add_column_welcome_message_to_stats cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200115_145124_add_column_welcome_message_to_stats cannot be reverted.\n";

        return false;
    }
    */
}
