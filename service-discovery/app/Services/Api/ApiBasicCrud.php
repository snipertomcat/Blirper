<?php

namespace App\Services\Api;

use Psr\Http\Message\ResponseInterface;

interface ApiBasicCrud
{
    public function create(array $params) : ResponseInterface;
    public function read() : string;
    public function update(array $params) : ResponseInterface;
    public function delete(int $id) : string;
}
