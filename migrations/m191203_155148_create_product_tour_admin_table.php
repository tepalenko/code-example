<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%product_tour_admin}}`.
 */
class m191203_155148_create_product_tour_admin_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_tour_admin}}', [
            'id' => $this->primaryKey(),
            'checker_username' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
        // creates index for column `checker_username`
        $this->createIndex(
            'idx-product_tour_admin-checker_username',
            'product_tour_admin',
            'checker_username'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_tour_admin}}');
    }
}
