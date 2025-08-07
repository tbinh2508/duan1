<?php

use App\Models\Order;
use App\Models\User;
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
            //Thông tin của users
            $table->foreignIdFor(User::class)->constrained();
            $table->string('sku')->unique();
            $table->string('slug')->unique();

            //Thông tin người nhận hàng
            $table->string('order_user_name');
            $table->string('order_user_email');
            $table->string('order_user_phone');
            $table->string('order_user_address');
            $table->string('order_user_note')->nullable();

            //Trạng thái đơn hàng
            $table->string('status_order')->default('pending');
            //Phương thức thanh toán
            $table->string('method_payment')->default('cash_delivery');
            //Trạng thái thanh toán
            $table->string('status_payment')->default('unpaid');
            //Tổng giá đơn hàng
            $table->decimal('order_total_price',15,0);

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
