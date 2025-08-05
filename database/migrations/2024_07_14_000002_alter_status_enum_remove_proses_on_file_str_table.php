<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AlterStatusEnumRemoveProsesOnFileStrTable extends Migration
{
    public function up()
    {
        \DB::statement("ALTER TABLE file_str MODIFY status ENUM('active', 'nonactive', 'changed', 'akan_berakhir', 'lifetime') DEFAULT 'active'");
    }

    public function down()
    {
        \DB::statement("ALTER TABLE file_str MODIFY status ENUM('active', 'proses', 'nonactive', 'changed', 'akan_berakhir', 'lifetime') DEFAULT 'active'");
    }
} 