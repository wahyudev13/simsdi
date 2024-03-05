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
        Schema::create('masa_berlaku_sip', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sip_id');
            $table->date('tgl_ed');
            $table->date('pengingat');
            $table->enum('status', ['active', 'proses','nonactive','changed','lifetime'])->default('active');
            $table->timestamps();

            $table->foreign('sip_id')->references('id')->on('file_sip')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('masa_berlaku_sip');
    }
};
