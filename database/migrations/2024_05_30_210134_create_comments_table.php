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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rId')->nullable()->references('id')->on('restaurants')->nullOnDelete()->required();
            $table->foreignId('uId')->nullable()->references('id')->on('users')->nullOnDelete()->required();
            $table->string('title', 100);
            $table->string('description', 700);
            $table->integer('rating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
