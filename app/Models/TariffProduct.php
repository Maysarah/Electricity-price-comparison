<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TariffProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'base_cost',
        'additional_kwh_cost',
        'included_kwh',
    ];
}
