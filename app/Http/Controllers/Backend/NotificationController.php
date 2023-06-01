<?php

namespace App\Http\Controllers\Backend;

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
                if ($notification->data['type'] == 'NewRequestHomestayNotification') {
                    $output .= '
                    <a href="javascript:;" class="navi-item">
						<div class="navi-link">
							<div class="navi-icon mr-2">
                                <i class="fas fa-home text-primary"></i>
						    </div>
                            <div class="navi-text">
                                <div class="font-weight-bold">' . $notification->data['message'] . '</div>
                                <div class="text-muted">' . $notification->created_at->diffForHumans() . '</div>
                            </div>
                        </div>
                    </a>';
                } elseif ($notification->data['type'] == 'NewBookingNotification') {
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
                } elseif ($notification->data['type'] == 'UpdatePaymentNotification') {
                    $output .= '
                    <a href="javascript:;" class="navi-item">
						<div class="navi-link">
							<div class="navi-icon mr-2">
                                <i class="fas fa-money-bill-wave text-warning"></i>
						    </div>
                            <div class="navi-text">
                                <div class="font-weight-bold">' . $notification->data['message'] . '</div>
                                <div class="text-muted">' . $notification->created_at->diffForHumans() . '</div>
                            </div>
                        </div>
                    </a>';
                } elseif ($notification->data['type'] == 'CancelBookingNotification') {
                    $output .= '
                    <a href="javascript:;" class="navi-item">
                        <div class="navi-link">
                            <i class="navi-icon mr-2 fas fa-times-circle text-danger"></i>
                            </div>
                            <div class="navi-text">
                                <div class="font-weight-bold">' . $notification->data['message'] . '</div>
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
