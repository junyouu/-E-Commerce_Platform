<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    use HasFactory;

    protected $primaryKey = 'variation_id';

    protected $fillable = [
        'product_id',
        'price',
        'stock',
        'image_url'
    ];

    public function orders() {
        return $this->hasMany(Order::class, 'variation_id');
    }
}
