<?php

use yii\db\Migration;

/**
 * Class m171017_102949_CreateUserTable
 */
class m171017_102949_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->text()->notNull(),
            'access_token' => $this->char(16)->notNull(),
            'created_at' => 'timestamp not null default current_timestamp',
            'updated_at' => 'timestamp not null default current_timestamp on update current_timestamp',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
