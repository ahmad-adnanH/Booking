<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            // الربط بمبنى
            $table->foreignId('building_id')->constrained()->cascadeOnDelete();

            $table->string('room_number');
            $table->string('name')->nullable();
            $table->integer('capacity');
            $table->integer('floor');            
            $table->enum('status', ['available', 'maintenance'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
