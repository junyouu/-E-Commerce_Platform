<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $primaryKey = 'seller_id';

    protected $fillable = [
        'user_id',
        'shop_name',
        'shop_description',
        'email',
        'phone_number',
        'image_url'
    ];
}
