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
        Schema::create('variation_mappings', function (Blueprint $table) {
            $table->unsignedBigInteger('variation_id'); 
            $table->unsignedBigInteger('attribute_value_id'); 

            $table->foreign('variation_id')->references('variation_id')->on('variations')->onDelete('cascade');
            $table->foreign('attribute_value_id')->references('attribute_value_id')->on('attribute_values')->onDelete('cascade');
            
            $table->primary(['variation_id', 'attribute_value_id']); // Composite Primary Key

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variation_mappings');
    }
};
