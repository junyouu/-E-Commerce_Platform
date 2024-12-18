<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewRecord extends Model
{
    use HasFactory;

    protected $primaryKey = 'view_id';

    protected $fillable = [
        'customer_id',
        'product_id'
    ];

}
