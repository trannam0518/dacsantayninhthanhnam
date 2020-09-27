<?php

use Illuminate\Database\Seeder;

class OrderDetails extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\OrderDetails::class,100)->create();
    }
}
