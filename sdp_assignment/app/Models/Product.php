<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'seller_id',
        'category_id',
        'label_id',
        'product_name',
        'product_description',
        'image_url'
    ];

    public function variations() {
        return $this->hasMany(Variation::class, 'product_id');
    }

}
