<?php

use yii\db\Migration;

/**
 * Handles the creation of table `balance`.
 */
class m171017_103955_create_balance_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('balance', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'amount' => $this->double(2)->defaultValue(0)->notNull(),
            'created_at' => 'timestamp not null default current_timestamp',
            'updated_at' => 'timestamp not null default current_timestamp on update current_timestamp',
        ]);

        $this->addForeignKey(
            'user_balance_fk',
            'balance',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('balance');
    }
}
