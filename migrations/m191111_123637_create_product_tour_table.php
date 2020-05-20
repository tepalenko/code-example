<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%product_tour}}`.
 */
class m191111_123637_create_product_tour_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_tour}}', [
            'id' => $this->primaryKey(),
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'show' =>  Schema::TYPE_TINYINT . ' DEFAULT 0',
            'category_id' => Schema::TYPE_INTEGER,
            'steps' => Schema::TYPE_TEXT,
        ]);
        // creates index for column `category_id`
        $this->createIndex(
            'idx-product_tour-category_id',
            'product_tour',
            'category_id'
        );

        // add foreign key for table `category`
        $this->addForeignKey(
            'fk-product_tour-category_id',
            'product_tour',
            'category_id',
            'category',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_tour}}');
    }
}
