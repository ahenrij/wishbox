<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(CategoriesTableSeeder::class);
         $this->call(UserCategoriesTableSeeder::class);
         $this->call(WishBoxesTableSeeder::class);
         $this->call(WishesTableSeeder::class);
         $this->call(CommentsTableSeeder::class);
    }
}
