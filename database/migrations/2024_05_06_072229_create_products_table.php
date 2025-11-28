<?php

use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;

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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('cost',10,2)->nullable();
            $table->integer('discount')->nullable();
            $table->decimal('sellingprice')->nullable();
            $table->decimal('price',10,2)->nullable();
            $table->decimal('total_cost')->nullable();
            $table->decimal('total_price')->nullable();
            $table->integer('qty')->nullable();
            $table->boolean('published')->default(0);
            $table->boolean('inStock')->default(0);
            $table->foreignIdFor(Supplier::class, 'supplier_id')->nullable()->constrained('suppliers');
            $table->foreignIdFor(Category::class, 'category_id')->nullable()->constrained('categories');
            $table->foreignIdFor(User::class, 'create_by')->nullable();
            $table->foreignIdFor(User::class, 'update_by')->nullable();
            $table->foreignIdFor(User::class,'deleted_by')->nullable();
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
        Schema::dropIfExists('products');
    }
};
