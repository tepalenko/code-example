<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%modal_tag_assn}}`.
 */
class m191117_152547_create_modal_tag_assn_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%modal_tag_assn}}', [
            'modal_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'tag_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);
        
        $this->addPrimaryKey('', '{{%modal_tag_assn}}', ['modal_id', 'tag_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%modal_tag_assn}}');
    }
}
