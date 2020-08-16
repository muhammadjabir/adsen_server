<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditTableCalonSiswaHarga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calon_siswa', function (Blueprint $table) {
            $table->double('harga',12,0)->nullable();
            $table->double('diskon',3,0)->nullable();
            $table->string('kode_invoice')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calon_siswa', function (Blueprint $table) {
            //
        });
    }
}
