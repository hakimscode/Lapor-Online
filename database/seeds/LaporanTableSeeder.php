<?php

use Illuminate\Database\Seeder;

class LaporanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Laporan::class, 10)->create();
    }
}
