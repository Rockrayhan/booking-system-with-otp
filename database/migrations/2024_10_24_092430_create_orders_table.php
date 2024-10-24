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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('product_id');
            $table->decimal('price', 8, 2);
            $table->string('user_name');
            $table->string('user_email');
            $table->string('user_id');
            $table->string('user_phone');
            $table->text('user_address');
            $table->boolean('status')->default(false); // New field
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
