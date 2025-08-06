<?php

use App\Models\Order;
use App\Models\ProductVariant;
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
            $table->foreignIdFor(Order::class)->constrained();
            $table->foreignIdFor(ProductVariant::class)->constrained();

            $table->unsignedInteger('quantity')->default(0);

            // Sao lưu thông tin sản phẩm
            $table->string('name');
            $table->string('sku');
            $table->string('img_thumbnail')->nullable();
            $table->decimal('price_regular', 15, 0);
            $table->decimal('price_sale', 15, 0)->nullable();

            // Sao lưu thông tin biến thể
            $table->string('variant_capacity_name');
            $table->string('variant_color_name');

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
