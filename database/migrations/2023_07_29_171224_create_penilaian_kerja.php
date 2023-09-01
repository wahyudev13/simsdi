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
        Schema::create('penilaian_kerja', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pegawai');
            $table->date('tgl_penilaian');
            $table->char('departemen_id',10);
            $table->string('jabatan');
            $table->string('jml_total');
            $table->enum('keterangan', ['Sangat Baik / Istimewa', 'Baik','Cukup','Kurang','Sangat Kurang']);
            $table->string('file');
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
        Schema::dropIfExists('penilaian_kerja');
    }
};
