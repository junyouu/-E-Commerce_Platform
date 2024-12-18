<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'customer_id', 
        'variation_id', 
        'quantity',
        'total_price',
        'order_status'
    ];

    public function variation() {
        return $this->belongsTo(Variation::class);
    }
}
