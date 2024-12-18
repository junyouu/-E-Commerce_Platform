<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{
    use HasFactory;

    protected $primaryKey = 'search_id';

    protected $fillable = [
        'customer_id',
        'search_query',
        'result_label',
    ];
}
