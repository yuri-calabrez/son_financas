<?php

use Phinx\Migration\AbstractMigration;

class CreateBillPays extends AbstractMigration
{
    public function up()
    {
       $this->table('bill_pays')
        ->addColumn('date_launch', 'date')
        ->addColumn('name', 'string')
        ->addColumn('value', 'float')
        ->addColumn('user_id', 'integer')
        ->addColumn('category_cost_id', 'integer')
        ->addForeignKey('user_id', 'users', 'id')
        ->addForeignKey('category_cost_id', 'category_costs', 'id')
        ->addTimestamps()
        ->save();

    }

   public function down()
   {
        $this->dropTable('bill_pays');
   }
}
