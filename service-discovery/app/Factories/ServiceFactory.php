<?php

namespace App\Factories;

use App\DataObjects\DataObjectContract;
use App\DataObjects\ServiceObject;
use Illuminate\Support\Arr;

class ServiceFactory
{
    public function make(string $name): DataObjectContract
    {
        return new ServiceObject(
            name: $name
        );
    }
}
