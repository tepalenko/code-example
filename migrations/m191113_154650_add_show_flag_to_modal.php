<?php

use yii\db\Migration;

/**
 * Class m191113_154650_add_show_flag_to_modal
 */
class m191113_154650_add_show_flag_to_modal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%modal}}', 'show_logo', 'TINYINT(1) DEFAULT 0 AFTER `name` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191113_154650_add_show_flag_to_modal cannot be reverted.\n";

        return false;
    }
}
