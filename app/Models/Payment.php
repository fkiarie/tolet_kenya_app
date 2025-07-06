<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'unit_id',
        'payment_date',
        'month_for',
        'amount',
        'commission_amount',
        'commission_rate',
        'landlord_amount',
        'method',
        'reference',
        'status',
        'notes',
    ];

    /**
     * Get the tenant that owns the payment.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the unit associated with the payment.
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Accessor for formatted payment date.
     */
    public function getFormattedDateAttribute(): string
{
    return $this->payment_date
        ? \Carbon\Carbon::parse($this->payment_date)->format('F j, Y')
        : '';
}


    /**
     * Accessor for month in readable format (e.g., July 2025).
     */
    public function getFormattedMonthAttribute(): string
    {
        return \Carbon\Carbon::parse($this->month_for . '-01')->format('F Y');
    }
}
// This model represents a payment made by a tenant, including relationships to the tenant and unit, and various payment details.
// It includes accessors for formatted date and month, making it easier to display in views.
// The model uses the HasFactory trait for factory-based testing and seeding.