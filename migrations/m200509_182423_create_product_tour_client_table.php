<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%product_tour_client}}`.
 */
class m200509_182423_create_product_tour_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_tour_client}}', [
            'id' => $this->primaryKey(),
            'hostname' => Schema::TYPE_STRING . ' NOT NULL',
            'sub_directory_name' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_tour_client}}');
    }
}
