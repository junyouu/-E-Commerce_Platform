<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute_Value extends Model
{
    use HasFactory;

    protected $table = 'attribute_values';
    protected $primaryKey = 'attribute_value_id';

    protected $fillable = [
        'attribute_id',
        'attribute_value'
    ];

    public function productAttribute()
    {
        return $this->belongsTo(Product_Attribute::class, 'attribute_id');
    }
}
