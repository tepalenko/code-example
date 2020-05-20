<?php

use yii\db\Migration;

/**
 * Class m191203_072627_add_auto_show_to_modal
 */
class m191203_072627_add_auto_show_to_modal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%modal}}', 'auto_show', 'TINYINT(1) DEFAULT 0 AFTER `show` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191203_072627_add_auto_show_to_modal cannot be reverted.\n";

        return false;
    }
}
