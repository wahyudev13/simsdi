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
        Schema::create('verif_str', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('str_id');
            $table->string('file_verif');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('str_id')->references('id')->on('file_str')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verif_str');
    }
};
