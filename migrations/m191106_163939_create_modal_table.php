<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `modal`.
 */
class m191106_163939_create_modal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%modal}}', [
            'id' => $this->primaryKey(),
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'logo' => Schema::TYPE_TEXT . ' DEFAULT NULL',
            'category_id' => Schema::TYPE_INTEGER,
        ]);


         // creates index for column `category_id`
         $this->createIndex(
             'idx-modal-category_id',
             'modal',
             'category_id'
         );

        // add foreign key for table `category`
        $this->addForeignKey(
            'fk-modal-category_id',
            'modal',
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
        // drops foreign key for table `category`
        $this->dropForeignKey(
            'fk-modal-category_id',
            'modal'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            'idx-modal-category_id',
            'modal'
        );

        $this->dropTable('{{%modal}}');
    }
}
