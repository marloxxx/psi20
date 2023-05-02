<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function counter()
    {
        $total = Auth::user()->unreadNotifications->count();
        return response()->json([
            'total' => $total,
        ]);
    }

    public function notification()
    {
        $output = '';

        if (Auth::user()->notifications->count() > 0) {
            foreach (Auth::user()->notifications as $notification) {
                if ($notification->type == 'topup') {
                    $output .= '
                    <a href="javascript:;" class="navi-item">
						<div class="navi-link">
							<div class="navi-icon mr-2">
                                <i class="fas fa-money-bill-wave text-success"></i>
						    </div>
                            <div class="navi-text">
                                <div class="font-weight-bold">' . $notification->data['message'] . '</div>
                                <div class="text-muted">' . $notification->created_at->diffForHumans() . '</div>
                            </div>
                        </div>
                    </a>';
                } elseif ($notification->type == 'coupon') {
                    $output .= '
                    <a href="javascript:;" class="navi-item">
                        <div class="navi-link">
                            <div class="navi-icon mr-2">
                                <i class="fas fa-gift text-warning"></i>
                            </div>
                            <div class="navi-text">
                                <div class="font-weight-bold">' . $notification->message . '</div>
                                <div class="text-muted">' . $notification->created_at->diffForHumans() . '</div>
                            </div>
                        </div>
                    </a>';
                }
            }
        } else {
            $output .= '
            <a href="javascript:;" class="navi-item">
                <div class="navi-link">
                    <div class="navi-text">
                        <div class="font-weight-bold">Belum ada notifikasi</div>
                    </div>
                </div>
            </a>';
        }

        Auth::user()->unreadNotifications->markAsRead();
        return response()->json([
            'notifications' => $output,
        ]);
    }
}
