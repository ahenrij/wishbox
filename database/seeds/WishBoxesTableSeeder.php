<?php

use Illuminate\Database\Seeder;

class WishBoxesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\WishBox::class, 50)->create();
    }
}
