<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%tutorial_stats}}`.
 */
class m191125_102927_create_tutorial_stats_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tutorial_stats}}', [
            'id' => $this->primaryKey(),
            'unique_user_id' => Schema::TYPE_TEXT . ' NOT NULL',
            'modal_id' => Schema::TYPE_INTEGER,
            'product_tour_id' => Schema::TYPE_INTEGER,
            'step' => Schema::TYPE_INTEGER,
            'create_at' => $this->timestamp()->notNull(),
        ]);

        // creates index for column `modal_id`
        $this->createIndex(
            'idx-tutorial_stats-modal_id',
            'tutorial_stats',
            'modal_id'
        );
        // creates index for column `product_tour_id`
        $this->createIndex(
            'idx-tutorial_stats-product_tour_id',
            'tutorial_stats',
            'product_tour_id'
        );

        // add foreign key for table `modal`
        $this->addForeignKey(
            'fk-tutorial_stats-modal_id',
            'tutorial_stats',
            'modal_id',
            'modal',
            'id',
            'CASCADE'
        );
        // add foreign key for table `product_tour`
        $this->addForeignKey(
            'fk-tutorial_stats-product_tour_id',
            'tutorial_stats',
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
        $this->dropTable('{{%tutorial_stats}}');
    }
}
