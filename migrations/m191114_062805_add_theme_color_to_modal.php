<?php

use yii\db\Migration;

/**
 * Class m191114_062805_add_theme_color_to_modal
 */
class m191114_062805_add_theme_color_to_modal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%modal}}', 'theme_color', 'VARCHAR(255) DEFAULT NULL AFTER `category_id` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191114_062805_add_theme_color_to_modal cannot be reverted.\n";

        return false;
    }
}
