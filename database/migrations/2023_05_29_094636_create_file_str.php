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
        Schema::create('file_str', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pegawai');
            // $table->string('nik_pegawai',20);
            $table->unsignedBigInteger('nama_file_str_id');
            $table->string('no_reg_str', 100);
            $table->string('kompetensi', 100);
            $table->string('file');
            $table->date('tgl_ed');
            $table->enum('status', ['active', 'proses','nonactive','changed'])->default('active');
            $table->timestamps();

            $table->foreign('nama_file_str_id')->references('id')->on('master_berkas_pegawai')->onUpdate('cascade')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_str');
    }
};
