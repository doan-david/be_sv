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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->date('birthday')->nullable();
            $table->string('address')->nullable();
            $table->string('image')->nullable();
            $table->string('authentication_code')->nullable();
            $table->string('forget_password_token')->nullable();
            $table->integer('number_login_failed')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table-> unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
