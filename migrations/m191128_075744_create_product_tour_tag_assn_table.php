<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%product_tour_tag_assn}}`.
 */
class m191128_075744_create_product_tour_tag_assn_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_tour_tag_assn}}', [
            'product_tour_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'tag_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_tour_tag_assn}}');
    }
}
