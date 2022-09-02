<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discounts extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'pack_value',
        'pack_size',
        'applies_to',
        'bogo_limit',
        'bogo_gets'
    ];
}
