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
        Schema::create('lost_items',function(Blueprint $table){
           $table->id();
           $table->string('item_name');
            $table->string('category')->default('Other');
           $table->text('description')->nullable();
           $table->string('location_lost')->nullable();
           $table->date('date_lost');
           $table->string('owner_name');
           $table->string('photo')->nullable();
           $table->enum('status',['lost','found','returned'])->default('lost');
           $table->timestamps();
        });
          
    }

   
    public function down(): void
    {
        
    }
};