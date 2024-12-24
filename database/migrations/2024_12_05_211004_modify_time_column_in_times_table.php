<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('times', function (Blueprint $table) {
            $table->time('time')->change(); // Change 'time' column to 'time' type
        });
    }
    
    public function down()
    {
        Schema::table('times', function (Blueprint $table) {
            $table->string('time')->change(); // Revert back to 'string' type
        });
    }
    
};
