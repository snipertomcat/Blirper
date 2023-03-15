<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Token extends Model
{
    use HasFactory;

    protected $fillable = ['service', 'token', 'ttl', 'device_type', 'address'];

}
