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
        Schema::create('restaurant_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rId')->nullable()->references('id')->on('restaurants')->nullOnDelete()->required();
            $table->foreignId('cId')->nullable()->references('id')->on('contacts')->nullOnDelete()->required();
            $table->string('url', 300);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_contacts');
    }
};
