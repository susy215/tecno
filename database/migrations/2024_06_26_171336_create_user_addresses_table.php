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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('profile', 225)->nullable();
            $table->string('delivery')->nullable();
            $table->boolean('isMain')->default(1);
            $table->foreignId('user_id')->nullable()->constrained('users');
            // $table->unsignedBigInteger('user_id')->nullable(); // Make it nullable initially
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }

};
