<?php

use Phinx\Migration\AbstractMigration;

class CreateBillReceivesTable extends AbstractMigration
{
    public function up()
   {
       $this->table('bill_receives')
        ->addColumn('date_launch', 'date')
        ->addColumn('name', 'string')
        ->addColumn('value', 'float')
        ->addColumn('user_id', 'integer')
        ->addForeignKey('user_id', 'users', 'id')
        ->addTimestamps()
        ->save();

   }

   public function down()
   {
        $this->dropTable('bill_receives');
   }
}
