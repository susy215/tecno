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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                  ->constrained('orders') // Creates a foreign key to the orders table
                  ->onDelete('cascade')   // Ensures that if an order is deleted, associated order items are also deleted
                  ->onUpdate('cascade')->nullable(); // Ensures that if an order ID is updated, it will be updated in the order_items table
                  $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade')  // Automatically deletes order items when the referenced product is deleted
                  ->onUpdate('cascade')->nullable();   // Ensures that if a product ID is updated, it will be updated in the order_items table
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
