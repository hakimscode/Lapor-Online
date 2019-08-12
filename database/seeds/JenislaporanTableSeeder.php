<?php

use Illuminate\Database\Seeder;

class JenislaporanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Jenislaporan::class, 4)->create();
    }
}
