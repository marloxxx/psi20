<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Homestay extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'homestays';
    protected $guarded = [];

    public function homestayHasFacilities()
    {
        return $this->hasMany(HomestayHasFacility::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'homestay_has_facilities');
    }

    public function getPrimaryImageAttribute()
    {
        return $this->images()->where('is_primary', true)->first();
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
