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
        Schema::create('file_vaksin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pegawai');
            // $table->unsignedBigInteger('nama_file_kesehatan_id');
            $table->string('dosis');
            $table->string('jenis_vaksin');
            $table->date('tgl_vaksin');
            $table->string('tempat_vaksin');
            $table->string('file');
            $table->timestamps();

            // $table->foreign('nama_file_kesehatan_id')->references('id')->on('master_berkas_pegawai')->onUpdate('cascade')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_vaksin');
    }
};
