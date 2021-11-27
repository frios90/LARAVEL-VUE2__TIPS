<?php

use Faker\Generator as Faker;
use App\Entities\Commune;
use App\Entities\Company;

$factory->define(App\Entities\Staff::class, function (Faker $faker) {
    return [
        'rut' => $faker->numberBetween($min = 100000000, $max = 999999999),
        'name' => $faker->Name,
        'email' => $faker->Email,
        'phone' => $faker->numberBetween($min = 100000000, $max = 999999999),
        'address' => $faker->Address,
        'country' => $faker->Country,
        'commune_id' => Commune::where('name', '=', 'Santiago')->first()->id,
        'company_id' => Company::where('rut', '=', '17.482.835-0')->first()->id,

    ];
});
