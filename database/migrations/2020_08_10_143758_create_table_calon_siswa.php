<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCalonSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calon_siswa', function (Blueprint $table) {
            $table->id();
            $table->string('email',100)->index();
            $table->string('nama',100);
            $table->string('nohp',20);
            $table->string('nowa',20);
            $table->tinyInteger('kelas')->index();
            $table->enum('status',['Mahasiswa','Karyawan']);
            $table->softDeletes();
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
        Schema::dropIfExists('calon_siswa');
    }
}
