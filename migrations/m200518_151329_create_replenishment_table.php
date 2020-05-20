<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%replenishment}}`.
 */
class m200518_151329_create_replenishment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('replenishments', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'amount' => $this->decimal()->notNull(),
            'date' => $this->dateTime(),
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            'idx-replenishments-users_id',
            'replenishments',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-replenishments-users_id',
            'replenishments',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-replenishments-users_id',
            'replenishments'
        );
        $this->dropForeignKey(
            'fk-replenishments-users_id',
            'replenishments'
        );
        $this->dropTable('replenishment');
    }
}
