<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'vehicle_id',
        'driver_id',
        'created_by',
        'requester_name',
        'purpose',
        'destination',
        'start_datetime',
        'end_datetime',
        'passenger_count',
        'status',
        'notes',
        'actual_start',
        'actual_end',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime'   => 'datetime',
        'actual_start'   => 'datetime',
        'actual_end'     => 'datetime',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvals()
    {
        return $this->hasMany(BookingApproval::class);
    }
}