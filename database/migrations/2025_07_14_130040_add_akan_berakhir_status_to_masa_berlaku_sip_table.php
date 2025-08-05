<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE masa_berlaku_sip MODIFY COLUMN status ENUM('active', 'akan_berakhir', 'nonactive', 'changed', 'lifetime') DEFAULT 'active'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE masa_berlaku_sip MODIFY COLUMN status ENUM('active', 'nonactive', 'changed', 'lifetime') DEFAULT 'active'");
    }
};
