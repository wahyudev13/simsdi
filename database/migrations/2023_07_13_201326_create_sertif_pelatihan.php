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
        Schema::create('sertif_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pegawai');
            $table->unsignedBigInteger('berkas_id');
            $table->string('nm_kegiatan',100);
            $table->date('tgl_kegiatan');
            $table->string('tmp_kegiatan',100);
            $table->string('penyelenggara',100);
            $table->string('file');
            $table->timestamps();

            $table->foreign('berkas_id')->references('id')->on('master_berkas_pegawai')->onUpdate('cascade')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sertif_pelatihan');
    }
};
