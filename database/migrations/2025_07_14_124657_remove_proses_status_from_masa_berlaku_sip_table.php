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
        // Update existing records with 'proses' status to 'active'
        DB::statement("UPDATE masa_berlaku_sip SET status = 'active' WHERE status = 'proses'");
        
        // Modify the enum to remove 'proses'
        DB::statement("ALTER TABLE masa_berlaku_sip MODIFY COLUMN status ENUM('active', 'nonactive', 'changed', 'lifetime') DEFAULT 'active'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Add back 'proses' to the enum
        DB::statement("ALTER TABLE masa_berlaku_sip MODIFY COLUMN status ENUM('active', 'proses', 'nonactive', 'changed', 'lifetime') DEFAULT 'active'");
    }
};
