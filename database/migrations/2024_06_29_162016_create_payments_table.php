<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->references('id')->on('orders');
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('status', 45)->nullable();
            $table->string('type', 45)->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('imagepay')->nullable();
            $table->string('delivery')->nullable();
            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->foreignIdFor(User::class, 'updated_by')->nullable();
            $table->foreignId('delivery_id')->nullable()->constrained('deliveries');
            $table->datetime('created_date')->nullable();
            $table->datetime('updated_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
