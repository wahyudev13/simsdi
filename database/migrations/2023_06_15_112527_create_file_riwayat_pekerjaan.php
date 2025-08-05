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
        Schema::create('file_riwayat_pekerjaan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pegawai');
            // $table->string('nik_pegawai',20);
            $table->unsignedBigInteger('nama_file_riwayat_id');
            $table->string('nomor', 100);
            $table->string('file');
            $table->date('tgl_ed')->nullable();
            $table->enum('status', ['active', 'proses','nonactive','changed'])->default('active')->nullable();
            $table->timestamps();

            $table->foreign('nama_file_riwayat_id')->references('id')->on('master_berkas_pegawai')->onUpdate('cascade')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('riwayat_pekerjaan');
    }
};
