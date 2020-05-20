<?php

use yii\db\Migration;

/**
 * Class m191211_190932_add_author_to_product_tour_table
 */
class m191211_190932_add_author_to_product_tour_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_tour}}', 'author_id', 'INT(11) DEFAULT 1 AFTER `category_id` ');
        // creates index for column `author_id`
        $this->createIndex(
            'idx-product_tour-author_id',
            'product_tour',
            'author_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-product_tour-author_id',
            'product_tour',
            'author_id',
            'product_tour_admin',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191211_190932_add_author_to_product_tour_table cannot be reverted.\n";

        return false;
    }
}
