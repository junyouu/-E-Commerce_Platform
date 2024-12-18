<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariationMapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute_value_id',
        'variation_id'
    ];
}
