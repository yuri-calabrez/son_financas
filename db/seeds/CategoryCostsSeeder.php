<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class CategoryCostsSeeder extends AbstractSeed
{
     const NAMES = [
        'Telefone',
        'Supermercado',
        'Água',
        'Escola',
        'Cartão',
        'Luz',
        'IPVA',
        'Imposto de Renda',
        'Gasolina',
        'Vestuário',
        'Entretenimento',
        'Reparos'
    ];
    public function run()
    {
        $faker = Factory::create('pt_BR');
        $faker->addProvider($this);
        $data = [];
        $categoryCosts = $this->table('category_costs');
        foreach (range(1, 20) as $value) {
           $data[] = [
                'name' => $faker->categoryName(),
                'user_id' => rand(1, 4),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
           ];
        }

        $categoryCosts->insert($data)->save();
    }

    public function categoryName()
    {
        return \Faker\Provider\Base::randomElement(self::NAMES);
    }
}
