<?php

use App\Models\Category;
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
            $table->foreignIdFor(Category::class)->constrained();
            $table->string('name', 255)->unique();
            $table->string('sku')->unique(); // Mã sản phẩm
            $table->string('slug', 255)->unique(); // Đường dẫn
            $table->text('description')->nullable(); // Mô tả
            $table->string('img_thumbnail')->nullable(); // Ảnh chính
            $table->decimal('price_regular', 15, 0)->default(0);
            $table->decimal('price_sale', 15, 0)->default(0);
            $table->unsignedBigInteger('views')->default(0);
            $table->boolean('featured')->default(0);
            $table->decimal('prating', 5, 1)->default(0)->comment('Đánh giá ');
            $table->boolean('is_hot')->default(0)->comment("0 : Không hot, 1 : Có hot");
            $table->boolean('is_active')->default(true);

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
