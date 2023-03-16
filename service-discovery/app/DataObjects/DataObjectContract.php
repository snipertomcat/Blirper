<?php

namespace App\DataObjects;

interface DataObjectContract
{
    public function toArray(): array;
    public function toJson(): string    ;
}
