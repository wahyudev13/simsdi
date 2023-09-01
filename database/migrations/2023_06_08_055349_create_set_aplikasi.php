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
        Schema::create('set_aplikasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_instansi');
            $table->string('no_telp');
            $table->string('email');
            $table->longText('alamat');
            $table->string('logo')->nullable();
            $table->string('time', 100)->default('08:00');
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
        Schema::dropIfExists('set_aplikasi');
    }
};
