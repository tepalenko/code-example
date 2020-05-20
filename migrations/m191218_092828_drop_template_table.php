<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%template}}`.
 */
class m191218_092828_drop_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        
        // drops foreign key for table `modal_slides`
        $this->dropForeignKey(
            'fk-modal-template_id',
            'modal_slides'
        );
        // drops index for column `modal_slides`
        $this->dropIndex(
            'idx-modal-slides-template_id',
            'modal_slides'
        );

        $this->dropTable('{{%templates}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('{{%template}}', [
            'id' => $this->primaryKey(),
        ]);
    }
}
