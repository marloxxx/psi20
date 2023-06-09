<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function homestay()
    {
        return $this->belongsTo(Homestay::class);
    }

    public function event()
    {
        return $this->belongsTo(Profile::class);
    }
}
