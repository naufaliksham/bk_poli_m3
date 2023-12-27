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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();

            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles'); // Ganti 'roles' sesuai dengan nama tabel yang dibuat di migrasi create_roles_table
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
