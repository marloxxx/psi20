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

    protected $appends = [
        'primary_image',
        'rating',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

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

    public function reviews()
    {
        return $this->bookings()->where('status', 'completed')->whereNotNull('rating');
    }

    public function getRatingAttribute()
    {
        return $this->bookings()->avg('rating');
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function isAvailable($checkin, $checkout)
    {
        $bookings = $this->bookings()->where('status', '!=', 'cancelled')->get();
        foreach ($bookings as $booking) {
            if ($checkin >= $booking->checkin && $checkin <= $booking->checkout) {
                return false;
            }
            if ($checkout >= $booking->checkin && $checkout <= $booking->checkout) {
                return false;
            }
        }
        return true;
    }

    public function getDays($checkin, $checkout)
    {
        $checkin = \Carbon\Carbon::parse($checkin);
        $checkout = \Carbon\Carbon::parse($checkout);
        return $checkin->diffInDays($checkout);
    }
}
