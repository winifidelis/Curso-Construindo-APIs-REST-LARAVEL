<?php

use Illuminate\Database\Seeder;
use App\Products;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Products::class, 30)->create();
    }
}
