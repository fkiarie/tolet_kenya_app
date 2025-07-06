<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id', 'unit_type','house_number', 'status', 'rent', 'deposit', 'lease_date', 'end_lease'
    ];

    protected $casts = [
        'lease_date' => 'date',
        'end_lease' => 'date',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function tenants()
{
    return $this->belongsToMany(Tenant::class)
                ->withPivot(['lease_date', 'end_of_lease'])
                ->withTimestamps();
}

}