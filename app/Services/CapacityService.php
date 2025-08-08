<?php

namespace App\Services;

use App\Models\Capacity;
use App\Repositories\CapacityRepository;

class CapacityService
{
    
    public function getCapacity()
    {
        return Capacity::query()->get();
    }
    public function createCapacity($data)
    {
        return Capacity::query()->create($data);
    }
    public function findIdCapacity($id)
    {
        return Capacity::query()->find($id);
    }
    public function updateCapacity($id, $data)
    {
        return Capacity::query()->find($id)->update($data);
    }
    public function pluckCapacity($column,$key){
        return Capacity::query()->where('is_active',1)->pluck($column,$key)->all();
    }
}
