<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%feature_announ_modal_tutorial_assn}}`.
 */
class m191121_162207_create_feature_announ_modal_tutorial_assn_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%feature_announ_modal_tutorial_assn}}', [
            'id' => $this->primaryKey(),
            'feature_announ_modal_id' => Schema::TYPE_INTEGER,
            'modal_id' => Schema::TYPE_INTEGER,
            'product_tour_id' => Schema::TYPE_INTEGER,
        ]);

        // creates index for column `modal_id`
        $this->createIndex(
            'idx-feature_announ_modal_tutorial_assn-modal_id',
            'feature_announ_modal_tutorial_assn',
            'modal_id'
        );
        // creates index for column `product_tour_id`
        $this->createIndex(
            'idx-feature_announ_modal_tutorial_assn-product_tour_id',
            'feature_announ_modal_tutorial_assn',
            'product_tour_id'
        );

        // add foreign key for table `modal`
        $this->addForeignKey(
            'fk-feature_announ_modal_tutorial_assn-modal_id',
            'feature_announ_modal_tutorial_assn',
            'modal_id',
            'modal',
            'id',
            'CASCADE'
        );
        // add foreign key for table `product_tour`
        $this->addForeignKey(
            'fk-feature_announ_modal_tutorial_assn-product_tour_id',
            'feature_announ_modal_tutorial_assn',
            'product_tour_id',
            'product_tour',
            'id',
            'CASCADE'
        );
         // add foreign key for table `modal`
        $this->addForeignKey(
            'fk-feature_announ_modal_tutorial_assn-feature_announ_modal_id',
            'feature_announ_modal_tutorial_assn',
            'feature_announ_modal_id',
            'modal',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%feature_announ_modal_tutorial_assn}}');
    }
}
