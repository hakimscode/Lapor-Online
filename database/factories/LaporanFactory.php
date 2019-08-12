<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Laporan;
use Faker\Generator as Faker;

$factory->define(Laporan::class, function (Faker $faker) {
    return [
        'jenis_laporan' => $faker->randomElement(App\JenisLaporan::pluck('id')->toArray()),
        'user_id' => $faker->randomElement(App\User::pluck('id')->toArray()),
        'tanggal_kejadian' => $faker->datetime(),
        'tanggal_lapor' => $faker->datetime(),
        'judul_laporan' => $faker->sentence(),
        'deskripsi_laporan' => $faker->paragraph(),
        'alamat' => $faker->address,
        'latitude' => $faker->latitude(),
        'longitude' => $faker->longitude(),
        'gambar' => $faker->imageUrl(),
        'verified' => 0,
        'status' => 0
    ];
});
