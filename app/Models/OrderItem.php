<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_variant_id',
        'order_id',
        'quantity',
        'name',
        'sku',
        'img_thumbnail',
        'price_regular',
        'price_sale',
        'variant_capacity_name',
        'variant_color_name',
    ];
}
