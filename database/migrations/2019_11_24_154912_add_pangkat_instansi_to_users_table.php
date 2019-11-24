<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPangkatInstansiToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('pangkat')->after('no_ktp');
            $table->string('jabatan')->after('pangkat');
            $table->string('instansi')->after('jabatan');
            $table->string('alamat')->after('instansi');
            $table->string('no_hp')->after('alamat');
            $table->string('email')->after('no_hp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
