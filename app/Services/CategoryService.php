<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    
    public function getCategory()
    {
        return Category::query()->get();
    }
    public function createCategory($data)
    {
        return Category::query()->create($data);
    }
    public function findIdCategory($id)
    {
        return Category::query()->find($id);
    }
    public function findSlugCategory($slug)
    {
        return Category::query()->where('slug',$slug)->first();
    }
    public function updateCategory($id, $data = [])
    {
        return Category::query()->findOrFail($id)->update($data);
    }
    // public function deleteCategory($id)
    // {
    //     return Category::query()->find($id)->delete();
    // }
    public function pluckCategory($column, $key)
    {
        return Category::query()->pluck($column, $key);
    }
}
