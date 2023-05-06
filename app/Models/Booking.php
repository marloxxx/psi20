<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELED = 'canceled';

    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
    ];

    public function homestay()
    {
        return $this->belongsTo(Homestay::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function status()
    {
        switch ($this->status) {
            case 'pending':
                return '<span class="badge badge-secondary">Menunggu</span>';
                break;
            case 'confirmed':
                return '<span class="badge badge-primary">Dikonfirmasi</span>';
                break;
            case 'approved':
                return '<span class="badge badge-success">Disetujui</span>';
                break;
            case 'rejected':
                return '<span class="badge badge-danger">Ditolak</span>';
                break;
            case 'completed':
                return '<span class="badge badge-success">Selesai</span>';
                break;
            case 'canceled':
                return '<span class="badge badge-danger">Dibatalkan</span>';
                break;
            default:
                return '<span class="badge badge-secondary">Pending</span>';
                break;
        }
    }

    // public function payment_status()
    // {
    //     switch ($this->payment_status) {
    //         case 1:
    //             return '<span class="badge badge-secondary">Pending</span>';
    //             break;
    //         case 2:
    //             return '<span class="badge badge-success">Success</span>';
    //             break;
    //         case 3:
    //             return '<span class="badge badge-danger">Failed</span>';
    //             break;
    //         case 4:
    //             return '<span class="badge badge-danger">Expired</span>';
    //             break;
    //         default:
    //             return '<span class="badge badge-secondary">Pending</span>';
    //             break;
    //     }
    // }
}
