<?php

use Faker\Generator as Faker;


$factory->define(App\Entities\Company::class, function (Faker $faker) {
    return [
        'rut' => $faker->numberBetween($min = 100000000, $max = 999999999),
        'name' => $faker->Company,
        'legal_name' => $faker->Company,
        'contact' => $faker->Company,
        'since' => date('Y-m-d'),

        'email' => $faker->Email,
        'phone' => $faker->numberBetween($min = 100000000, $max = 999999999),
        'address' => $faker->Address,
        'since' => $faker->Date,
        'commune_id' => 1
    ];
});
