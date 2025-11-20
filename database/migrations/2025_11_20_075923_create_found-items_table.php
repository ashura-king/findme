<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('found_items', function (Blueprint $table) {
        $table->id();
        $table->string('item_name');
        $table->string('category');
        $table->text('description')->nullable();
        $table->string('location_found');
        $table->date('date_found');
        $table->string('finder_name');
        $table->string('finder_contact');
        $table->string('photo')->nullable();
        $table->enum('status', ['unclaimed', 'claimed'])->default('unclaimed');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};