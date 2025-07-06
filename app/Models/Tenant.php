<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name', 'id_number', 'phone', 'email',
        'emergency_name', 'emergency_phone', 'photo'
    ];

public function units()
{
    return $this->belongsToMany(Unit::class)
                ->withPivot(['lease_date', 'end_of_lease'])
                ->withTimestamps();
}
}
