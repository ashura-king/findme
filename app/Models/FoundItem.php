<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoundItem extends Model
{
    protected $fillable = [
        'item_name','category','description','location_found',
        'date_found','finder_name','finder_contact','photo','status'
    ];
}