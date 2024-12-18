<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $primaryKey = 'voucher_id';

    protected $fillable = [
        'seller_id',
        'voucher_description',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'usage_limit',
        'usage_count'
    ];
}
