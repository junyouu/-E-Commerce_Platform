<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;

    protected $primaryKey = 'label_id';

    protected $fillable = [
        'category_id',
        'label_name'
    ];
}
