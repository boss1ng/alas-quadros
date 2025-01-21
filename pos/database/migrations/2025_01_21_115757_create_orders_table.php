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
            $table->string('customer_name');
            $table->json('orders'); // JSON column to store ordered items (menu_id and quantity)
            $table->integer('discount');
            $table->decimal('total_price', 10, 2);
            $table->boolean('isPaid')->default(false); // Set default to false or true
            $table->boolean('isCooking')->default(false);
            $table->boolean('isServed')->default(false);
            $table->string('notes')->default('');
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
