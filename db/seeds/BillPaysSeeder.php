<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class BillPaysSeeder extends AbstractSeed
{
    private $categories;
     
    public function run()
    {
        require __DIR__ . '/../bootstrap.php';
        $this->categories = \SONFin\Models\CategoryCost::all();
        $faker = Factory::create('pt_BR');
        $faker->addProvider($this);
        $data = [];
        $billPays = $this->table('bill_pays');
        foreach (range(1, 20) as $value) {
            $userId = rand(1, 4);
           $data[] = [
                'name' => $faker->word,
                'date_launch' => $faker->dateTimeBetween('-1 month')->format('Y-m-d'),
                'value' => $faker->randomFloat(2, 10, 1000),
                'user_id' => $userId,
                'category_cost_id' => $faker->categoryId($userId),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
           ];
        }

        $billPays->insert($data)->save();
    }

    public function categoryId($userId)
    {
        $categories = $this->categories->where('user_id', $userId);
        $categories = $categories->pluck('id');
        return \Faker\Provider\Base::randomElement($categories->toArray());
    }
}
