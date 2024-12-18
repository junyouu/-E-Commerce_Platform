<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $primaryKey = 'review_id';

    protected $fillable = [
        'customer_id',
        'product_id',
        'rating_star',
        'review_text',
    ];
}
