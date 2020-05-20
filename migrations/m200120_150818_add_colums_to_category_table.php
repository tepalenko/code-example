<?php

use yii\db\Migration;

/**
 * Class m200120_150818_add_colums_to_category_table
 */
class m200120_150818_add_colums_to_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%category}}', 'logo_name', 'VARCHAR(255) DEFAULT NULL AFTER `icon` ');
        $this->addColumn('{{%category}}', 'theme', 'VARCHAR(255) DEFAULT NULL AFTER `icon` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200120_150818_add_colums_to_category_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200120_150818_add_colums_to_category_table cannot be reverted.\n";

        return false;
    }
    */
}
