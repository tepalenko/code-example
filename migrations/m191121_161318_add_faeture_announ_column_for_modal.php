<?php

use yii\db\Migration;

/**
 * Class m191121_161318_add_faeture_announ_column_for_modal
 */
class m191121_161318_add_faeture_announ_column_for_modal extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%modal}}', 'feature_announ', 'TINYINT(1) DEFAULT 0 AFTER `theme_color` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191121_161318_add_faeture_announ_column_for_modal cannot be reverted.\n";

        return false;
    }
}
