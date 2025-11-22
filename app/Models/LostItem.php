<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LostItem extends Model
{
    protected $fillable = [
        'item_name',
        'category',
        'description',
        'location_lost',
        'date_lost',
        'photo',
        'status'
    ];
}
