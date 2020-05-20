<?php

use yii\db\Migration;

/**
 * Class m191129_204021_add_secondary_theme_color_to_modal_table
 */
class m191129_204021_add_secondary_theme_color_to_modal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%modal}}', 'secondary_theme_color', 'VARCHAR(255) DEFAULT NULL AFTER `theme_color` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191129_204021_add_secondary_theme_color_to_modal_table cannot be reverted.\n";

        return false;
    }
}
