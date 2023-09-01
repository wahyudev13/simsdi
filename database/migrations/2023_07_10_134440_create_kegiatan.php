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
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->char('departemen_id',50);
            $table->string('nama');
            $table->unsignedBigInteger('jenis_kegiatans_id');
            $table->string('tempat',100);
            $table->date('tanggal');
            $table->date('tanggal2');
            $table->timestamps();

            $table->foreign('jenis_kegiatans_id')->references('id')->on('jenis_kegiatan')->onUpdate('cascade')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kegiatan');
    }
};
