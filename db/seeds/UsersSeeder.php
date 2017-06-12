<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{
    public function run()
    {
        $app = require __DIR__.'/../bootstrap.php';
        $auth = $app->service('auth');
        $faker = Factory::create('pt_BR');
        $users = $this->table('users');
        /*$users->insert([
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => 'admin@user.com',
            'password' =>  $auth->hashPassword('123456')
        ])->save();*/
        $data = [];
        foreach (range(1, 4) as $value) {
           $data[] = [
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->email,
                'password' =>  $auth->hashPassword('123456')
           ];
        }

        $users->insert($data)->save();
    }
}
