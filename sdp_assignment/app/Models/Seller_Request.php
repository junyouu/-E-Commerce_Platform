<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller_Request extends Model
{
    use HasFactory;

    protected $table = 'seller_requests';
    protected $primaryKey = 'request_id';

    protected $fillable = [
        'seller_id',
        'category_id',
        'label_name',
        'status'
    ];
}
