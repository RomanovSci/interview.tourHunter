<?php

use yii\db\Migration;

/**
 * Handles the creation of table `transaction`.
 */
class m171017_115235_create_transaction_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('transaction', [
            'id' => $this->primaryKey(),
            'amount' => $this->double(2)->notNull(),
            'sender_id' => $this->integer(11)->notNull(),
            'recipient_id' => $this->integer(11)->notNull(),
            'created_at' => 'timestamp not null default current_timestamp',
            'updated_at' => 'timestamp not null default current_timestamp on update current_timestamp',
        ]);

        $this->addForeignKey(
            'transaction_fk',
            'transaction',
            'sender_id',
            'user',
            'id',
            'NO ACTION',
            'NO ACTION'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('transaction');
    }
}
