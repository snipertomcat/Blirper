<?php

namespace App\Factories;

use App\DataObjects\DataObjectContract;
use App\DataObjects\ServiceObject;
use Illuminate\Support\Arr;

class ServiceFactory
{
    public function make(array $data): DataObjectContract
    {
        return new ServiceObject(
            name: Arr::get($data, 'name'),
        );
    }
}
