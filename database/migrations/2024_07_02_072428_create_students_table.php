<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('username');
            $table->string('password');
            $table->string('email')->unique();
            $table->string('gender')->nullable();
            $table->date('birthday')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('hobby')->nullable();
            $table->string('image')->nullable();
            $table->string('status');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('class_id')->nullable();
            $table->foreign('class_id')->references('id')->on('classes');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
