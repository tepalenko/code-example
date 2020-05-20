<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%product_tour_step}}`.
 */
class m191114_104248_create_product_tour_step_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_tour_step}}', [
            'id' => $this->primaryKey(),
            'product_tour_id' => Schema::TYPE_INTEGER,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'content' => Schema::TYPE_TEXT . ' DEFAULT NULL',
            'action' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'path' => Schema::TYPE_STRING . ' DEFAULT NULL',
        ]);

        // creates index for column `product_tour_id`
        $this->createIndex(
            'idx-product-tour-step-product_tour_id',
            'product_tour_step',
            'product_tour_id'
        );

        // add foreign key for table `product_tour`
        $this->addForeignKey(
            'fk-product_tour-product_tour_id',
            'product_tour_step',
            'product_tour_id',
            'product_tour',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_tour_step}}');
    }
}
