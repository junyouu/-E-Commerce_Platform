<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Attribute extends Model
{
    use HasFactory;

    protected $table = 'product_attributes';
    protected $primaryKey = 'attribute_id';

    protected $fillable = [
        'product_id',
        'attribute_name'
    ];

    public function values()
    {
        return $this->hasMany(Attribute_Value::class, 'attribute_id');
    }
}
