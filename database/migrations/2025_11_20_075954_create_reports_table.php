<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
      Schema::create('reports', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('lost_item_id')->nullable();
        $table->unsignedBigInteger('found_item_id')->nullable();
        $table->text('remarks')->nullable();
        $table->enum('status', ['matched', 'returned'])->default('matched');
        $table->timestamps();

        $table->foreign('lost_item_id')->references('id')->on('lost_items')->onDelete('cascade');
        $table->foreign('found_item_id')->references('id')->on('found_items')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};