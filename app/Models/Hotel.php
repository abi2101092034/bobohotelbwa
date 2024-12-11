<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    //
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'link_gmaps',
        'address',
        'thumbnail',
        'star_level',
        'slug',
        'city_id', // Pastikan ini ada
        'country_id', // Jika relevan
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function photos()
    {
        return $this->hasMany(HotelPhoto::class);
    }


    public function rooms()
    {
        return $this->hasMany(HotelRoom::class);
    }

    public function getLowesRoomPrice()
    {
        $minPrice = $this->rooms()->min('price');
        return $minPrice ?? 0;
    }
}
