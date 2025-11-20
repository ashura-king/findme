<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
     protected $fillable = ['lost_item_id','found_item_id','remarks','status'];
}