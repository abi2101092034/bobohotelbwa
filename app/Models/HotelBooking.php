<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelBooking extends Model
{
    //
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'hotel_id',
        'hotel_room_id',
        'room_id',
        'proof',
        'checkin_at',
        'checkout_at',
        'total_days',
        'total_amount',
        'is_paid'
    ];

    protected $casts = [
        'checkin_at' => 'date',
        'checkout_at' => 'date',
    ];


    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function hotel()
    {
        return $this->belongsTo(hotel::class, 'hotel_id');
    }

    public function room()
    {
        return $this->belongsTo(HotelRoom::class, 'hotel_room_id');
    }
}
