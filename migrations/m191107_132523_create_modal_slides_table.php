<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%modal_slides}}`.
 */
class m191107_132523_create_modal_slides_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%modal_slides}}', [
            'id' => $this->primaryKey(),
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'modal_id' => Schema::TYPE_INTEGER,
            'template_id' => Schema::TYPE_INTEGER,
            'slide_params' => Schema::TYPE_TEXT,
        ]);

        // creates index for column `template_id`
        $this->createIndex(
            'idx-modal-slides-template_id',
            'modal_slides',
            'template_id'
        );

        // add foreign key for table `templates`
        $this->addForeignKey(
            'fk-modal-template_id',
            'modal_slides',
            'template_id',
            'templates',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%modal_slides}}');
    }
}
