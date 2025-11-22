<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoundItem extends Model
{
    protected $fillable = [
        'item_name','category','description','location_found',
        'date_found','finder_name','finder_contact','photo','status'
    ];

     protected $casts = [
        'date_found' => 'date',
    ];

    // Scope for active found items
    public function scopeActive($query)
    {
        return $query->where('status', 'found');
    }

    // Scope for returned found items
    public function scopeReturned($query)
    {
        return $query->where('status', 'returned');
    }
}