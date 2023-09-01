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
        Schema::create('file_sip', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pegawai');
            // $table->string('nik_pegawai',20);
            $table->unsignedBigInteger('nama_file_sip_id');
            $table->string('no_sip', 100);
            $table->unsignedBigInteger('no_reg');
            // $table->date('tgl_ed_str');
            // $table->string('bikes', 100);
            $table->string('file');
            $table->timestamps();

            $table->foreign('nama_file_sip_id')->references('id')->on('master_berkas_pegawai')->onUpdate('cascade')->onDelete('NO ACTION');
            $table->foreign('no_reg')->references('id')->on('file_str')->onUpdate('cascade')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_sip');
    }
};
