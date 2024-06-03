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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name')->required();
            $table->string('description', 500)->default('');
            $table->string('address', 500)->default('');
            $table->foreignId('owner')->nullable()->references('id')->on('users')->default(null)->nullOnDelete()->nullable();
            $table->foreignId('uploader')->nullable()->references('id')->on('users')->default(null)->nullOnDelete()->nullable();
            $table->string('avatar')->default('');
            $table->float('lat');
            $table->float('lng');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
