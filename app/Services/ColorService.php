<?php

namespace App\Services;

use App\Models\Color;
use App\Repositories\ColorRepository;

class ColorService
{

    public function getColor()
    {
        return Color::query()->get();
    }
    public function findIdColor($id)
    {
        return Color::query()->find($id);
    }
    public function createColor($data)
    {
        return Color::query()->create($data);
    }
    public function updateColor($id, $data)
    {
        return Color::query()->findOrFail($id)->update($data);
    }

    public function pluckColor($column, $key)
    {
        return Color::query()->where('is_active',1)->pluck($column, $key);
    }
}
