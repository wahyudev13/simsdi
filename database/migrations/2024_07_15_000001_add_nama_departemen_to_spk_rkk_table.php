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
        Schema::table('spk_rkk', function (Blueprint $table) {
            $table->string('nama_departemen')->after('departemen_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spk_rkk', function (Blueprint $table) {
            $table->dropColumn('nama_departemen');
        });
    }
}; 