<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Repositories\ProductRepocitory;

class ProductService
{
    
    public function getProduct($relation)
    {
        return Product::with($relation)->get();
    }

    public function getFeaturedProduct($limit)
    {
        return Product::query()->limit($limit)->get();
    }
    public function createProduct($data)
    {
        return Product::query()->create($data);
    }
    public function findIDRelationProduct($id, $relation)
    {
        return Product::with($relation)->find($id);
    }
    public function findIDProduct($id)
    {
        return Product::query()->find($id);
    }
    public function paginateProduct($paginate)
    {
        return Product::query()->paginate($paginate);
    }
    public function productvariantFindbyProduct_id($id, $ralation)
    {
        return ProductVariant::with($ralation)->where('product_id',$id)->get();
    }
}
