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
        Schema::create('verif_ijazah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ijazah_id');
            $table->string('file');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('ijazah_id')->references('id')->on('file_ijazah')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verif_ijazah');
    }
};
