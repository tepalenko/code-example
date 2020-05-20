<?php

use yii\db\Migration;

/**
 * Class m200123_143221_add_auto_show_date_to_modal
 */
class m200123_143221_add_auto_show_date_to_modal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%modal}}',
            'auto_show_start_date',
            $this->timestamp()->defaultValue(null)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200123_143221_add_auto_show_date_to_modal cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200123_143221_add_auto_show_date_to_modal cannot be reverted.\n";

        return false;
    }
    */
}
