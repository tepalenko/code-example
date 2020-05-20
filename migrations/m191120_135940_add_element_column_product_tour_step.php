<?php

use yii\db\Migration;

/**
 * Class m191120_135940_add_element_column_product_tour_step
 */
class m191120_135940_add_element_column_product_tour_step extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_tour_step}}', 'element', 'VARCHAR(255) DEFAULT NULL AFTER `product_tour_id` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191120_135940_add_element_column_product_tour_step cannot be reverted.\n";

        return false;
    }
}
