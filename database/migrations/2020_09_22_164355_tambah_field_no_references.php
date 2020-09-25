<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahFieldNoReferences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('calon_siswa', 'no_reference')) {
            Schema::table('calon_siswa', function (Blueprint $table) {
                $table->dropColumn(['no_reference']);
                // $table->string('no_reference',40)->nullable()->index();
                // $table->string('encrypt_invoice',150)->nullable()->index();
            });
        }
        if (Schema::hasColumn('calon_siswa', 'encrypt_invoice')) {
            Schema::table('calon_siswa', function (Blueprint $table) {
                $table->dropColumn(['encrypt_invoice']);
                // $table->string('no_reference',40)->nullable()->index();
                // $table->string('encrypt_invoice',150)->nullable()->index();
            });
        }
        // Schema::table('calon_siswa', function (Blueprint $table) {
        //     $table->dropColumn(['no_reference','encrypt_invoice']);
        //     // $table->string('no_reference',40)->nullable()->index();
        //     // $table->string('encrypt_invoice',150)->nullable()->index();
        // });
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
