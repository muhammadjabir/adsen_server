<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditTableCalon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calon_siswa', function (Blueprint $table) {
            $table->text('catatan')->nullable();
            $table->tinyInteger('status_pendaftaran')->default(0);
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
