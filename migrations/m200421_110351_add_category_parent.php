<?php

use yii\db\Migration;

/**
 * Class m200421_110351_add_category_parent
 */
class m200421_110351_add_category_parent extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%category}}', 'parent', 'INT(11) DEFAULT 0 AFTER `id` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200421_110351_add_category_parent cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200421_110351_add_category_parent cannot be reverted.\n";

        return false;
    }
    */
}
