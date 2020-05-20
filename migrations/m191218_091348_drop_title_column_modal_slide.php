<?php

use yii\db\Migration;

/**
 * Class m191218_091348_drop_title_column_modal_slide
 */
class m191218_091348_drop_title_column_modal_slide extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('modal_slides', 'title');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191218_091348_drop_title_column_modal_slide cannot be reverted.\n";

        return false;
    }
}
