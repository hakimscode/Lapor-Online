<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaporansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('jenis_laporan');
            $table->integer('user_id');
            $table->dateTime('tanggal_kejadian');
            $table->dateTime('tanggal_lapor');
            $table->string('judul_laporan');
            $table->text('deskripsi_laporan');
            $table->string('alamat');
            $table->string('latitude');
            $table->string('longitude');
            $table->text('gambar');
            $table->tinyInteger('verified');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan');
    }
}
