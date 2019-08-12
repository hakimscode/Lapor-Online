<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Jenislaporan;

$factory->define(Jenislaporan::class, function (Faker $faker) {
    return [
        'jenis_laporan' => $faker->word
    ];
});
