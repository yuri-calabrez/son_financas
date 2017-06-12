<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class BillReceivesSeeder extends AbstractSeed
{
      const NAMES = [
        'Salário',
        'Bico',
        'Restituição de Imposto de Renda',
        'Vendas de produtos usados',
        'Bolsa de valores',
        'CDI',
        'Tesouro de direto',
        'Previdência Privada'
    ];
    public function run()
    {
        $faker = Factory::create('pt_BR');
        $faker->addProvider($this);
        $data = [];
        $categoryCosts = $this->table('bill_receives');
        foreach (range(1, 20) as $value) {
           $data[] = [
                'name' => $faker->billReceivesName(),
                'date_launch' => $faker->dateTimeBetween('-1 month')->format('Y-m-d'),
                'value' => $faker->randomFloat(2, 10, 1000),
                'user_id' => rand(1, 4),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
           ];
        }

        $categoryCosts->insert($data)->save();
    }

   public function billReceivesName()
    {
        return \Faker\Provider\Base::randomElement(self::NAMES);
    }
}
