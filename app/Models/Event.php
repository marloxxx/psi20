<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function getClosestHomestays()
    {
        $homestays = Homestay::with('images', 'facilities', 'bookings')->get();
        $closestHomestays = [];
        foreach ($homestays as $homestay) {
            $distance = $this->distance(
                $this->latitude,
                $this->longitude,
                $homestay->latitude,
                $homestay->longitude
            );
            if ($distance <= 5) {
                $closestHomestays[] = $homestay;
            }
        }
        return $closestHomestays;
    }

    private function distance($lat1, $lon1, $lat2, $lon2, $unit = "K")
    {
        $lat1 = (float) $lat1;
        $lon1 = (float) $lon1;
        $lat2 = (float) $lat2;
        $lon2 = (float) $lon2;
        $theta = $lon1 - $lon2;
        $dist =
            sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
            cos(deg2rad($lat1)) *
            cos(deg2rad($lat2)) *
            cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515; // unit in miles
        $unit = strtoupper($unit);
        if ($unit == "K") {
            return ($miles * 1.609344); // unit in km
        } else if ($unit == "N") {
            return ($miles * 0.8684); // unit in nautical miles
        } else {
            return $miles; // unit in miles
        }
    }
}
