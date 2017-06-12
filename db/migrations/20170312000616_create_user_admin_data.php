<?php

use Phinx\Migration\AbstractMigration;

class CreateUserAdminData extends AbstractMigration
{
    public function up()
    {
        $app = require __DIR__.'/../bootstrap.php';
        $auth = $app->service('auth');
        $users = $this->table('users');
        $users->insert([
            'first_name' => 'Admin',
            'last_name' => 'System',
            'email' => 'admin@user.com',
            'password' =>  $auth->hashPassword('123456')
        ])->save();
    }

    public function down()
    {
        $this->execute("DELETE FROM users WHERE email = 'admin@user.com'");
    }
}
