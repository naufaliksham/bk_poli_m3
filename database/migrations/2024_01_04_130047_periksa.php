<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periksa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_daftar_poli');
            $table->foreign('id_daftar_poli')->references('id')->on('daftar_poli')->onDelete('cascade');
            $table->dateTime('tgl_periksa');
            $table->text('catatan')->nullable();
            $table->unsignedInteger('biaya_periksa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periksa');
    }
};
