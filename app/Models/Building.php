<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'city', 'town', 'landlord_id', 'unit_types'
    ];

    protected $casts = [
        'unit_types' => 'array',
    ];

    public function landlord()
    {
        return $this->belongsTo(Landlord::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}

