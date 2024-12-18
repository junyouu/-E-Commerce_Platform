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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id('voucher_id');
            $table->unsignedBigInteger('seller_id');
            $table->string('voucher_description');
            $table->string('discount_type');
            $table->integer('discount_value');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('usage_limit');
            $table->integer('usage_count');
            $table->timestamps();

            $table->foreign('seller_id')->references('seller_id')->on('sellers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher');
    }
};
