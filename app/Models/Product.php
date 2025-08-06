<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name',
        'sku',
        'slug',
        'description',
        'img_thumbnail',
        'price_regular',
        'price_sale',
        'featured',
        'views',
        'category_id',
        'prating',
        'is_hot',
        'is_active'
    ];
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
    public function product_variant(){
        return $this->hasMany(ProductVariant::class);
    }

}
