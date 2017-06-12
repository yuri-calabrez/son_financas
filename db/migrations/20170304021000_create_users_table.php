<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
    public function up()
    {
        $this->table('users')
            ->addColumn('first_name', 'string')
            ->addColumn('last_name', 'string')
            ->addColumn('email', 'string')
            ->addColumn('password', 'string')
            ->addTimestamps()
            ->addIndex(['email'], ['unique' => true])
            ->save();
    }

     public function down()
    {
        $this->dropTable('users');
    }
}
