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
        Schema::create('plats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rId')->nullable()->references('id')->on('restaurants')->nullOnDelete()->required();
            $table->string('name')->required()->required();
            $table->decimal('price', 10, 2)->required();
            $table->foreignId('tId')->nullable()->references('id')->on('plat_types')->nullOnDelete()->required();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plats');
    }
};
