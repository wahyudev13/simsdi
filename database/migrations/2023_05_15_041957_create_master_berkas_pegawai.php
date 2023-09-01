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
        Schema::create('master_berkas_pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->enum('kategori', ['pendidikan', 'ijin','identitas','kompetensi','kesehatan','perjanjian','sk','orientasi','lain']);
            $table->string('nama_berkas');
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
        Schema::dropIfExists('master_berkas_pegawai');
    }
};
