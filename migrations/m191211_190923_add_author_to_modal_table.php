<?php

use yii\db\Migration;

/**
 * Class m191211_190923_add_author_to_modal_table
 */
class m191211_190923_add_author_to_modal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%modal}}', 'author_id', 'INT(11) DEFAULT 1 AFTER `theme_color` ');
        // creates index for column `author_id`
        $this->createIndex(
            'idx-modal-author_id',
            'modal',
            'author_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-modal-author_id',
            'modal',
            'author_id',
            'user',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191211_190923_add_author_to_modal_table cannot be reverted.\n";

        return false;
    }
}
