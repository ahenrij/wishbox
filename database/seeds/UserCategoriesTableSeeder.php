<?php

use Illuminate\Database\Seeder;

class UserCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\UserCategory::class, 10)->create();
    }
}
