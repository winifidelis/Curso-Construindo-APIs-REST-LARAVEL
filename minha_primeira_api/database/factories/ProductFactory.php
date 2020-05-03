<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Products;
use Faker\Generator as Faker;

$factory->define(Products::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'price' => $faker->randomFloat(2,0,8),
        'description' => $faker->text,
        'slug' => $faker->slug()
    ];
});
