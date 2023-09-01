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
        Schema::create('file_ijazah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pegawai');
            // $table->string('nik_pegawai',20);
            $table->unsignedBigInteger('nama_file_id');
            $table->string('nomor');
            $table->string('asal');
            $table->string('thn_lulus');
            $table->string('file');
            $table->timestamps();

            $table->foreign('nama_file_id')->references('id')->on('master_berkas_pegawai')->onUpdate('cascade')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_ijazah');
    }
};
