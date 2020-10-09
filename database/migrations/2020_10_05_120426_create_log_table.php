<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_history', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            
            $table->text('deskripsi')->nullable();
            $table->ipAddress('ip');
            $table->string('longitude',150)->nullable();
            $table->string('latitude',150)->nullable();
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
        Schema::dropIfExists('log_history');
    }
}
