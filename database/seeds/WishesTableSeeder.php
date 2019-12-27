<?php

use Illuminate\Database\Seeder;

class WishesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Wish::class, 500)->create();
    }
}
