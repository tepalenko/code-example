<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%product_tour}}`.
 */
class m191120_150205_drop_steps_column_from_product_tour_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('product_tour', 'steps');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('product_tour', 'steps', $this->string());
    }
}
