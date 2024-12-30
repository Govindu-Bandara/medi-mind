<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicinesTable extends Migration
{
    public function up()
{
    Schema::create('medicines', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->decimal('dosage', 8, 2); 
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('medicines');
    }
}
