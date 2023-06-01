<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Illuminate\Http\Request;
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
        $user = User::find(Auth::guard('web')->user()->id);
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->get();
        $output = '';
        if ($notifications->count() > 0) {
            foreach ($notifications as $notification) {
                if ($notification->type == 'ApprovedBookingNotification') {
                    $output .= '
                        <div class="notification_item d-flex">
                            <span class="icon">
                                <i class="fas fa-check-circle text-success"></i>
                            </span>
                            <span class="text">
                            ' . $notification->message . '
                                <br>
                                <small>' . $notification->created_at->diffForHumans() . '</small>
                            </span>
                        </div>
                    ';
                } elseif ($notification->type == 'RejectedBookingNotification') {
                    $output .= '
                        <div class="notification_item">
                            <div class="icon">
                                <i class="fas fa-times-circle text-danger"></i>
                            </div>
                            <div class="text">
                            ' . $notification->message . '
                                <br>
                                <small>' . $notification->created_at->diffForHumans() . '</small>
                            </div>
                        </div>
                    ';
                } elseif ($notification->type == 'CompleteBookingNotification') {
                    $output .= '
                        <div class="notification_item">
                            <div class="icon">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                            <div class="text">
                            ' . $notification->message . '
                                <br>
                                <small>' . $notification->created_at->diffForHumans() . '</small>
                            </div>
                        </div>
                    ';
                } elseif ($notification->type == 'ApprovedHomestayNotification') {
                    $output .= '
                        <div class="notification_item">
                            <div class="icon">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                            <div class="text">
                            ' . $notification->message . '
                                <br>
                                <small>' . $notification->created_at->diffForHumans() . '</small>
                            </div>
                        </div>
                    ';
                } elseif ($notification->type == 'RejectedHomestayNotification') {
                    $output .= '
                        <div class="notification_item">
                            <div class="icon">
                                <i class="fas fa-times-circle text-danger"></i>
                            </div>
                            <div class="text">
                            ' . $notification->message . '
                                <br>
                                <small>' . $notification->created_at->diffForHumans() . '</small>
                            </div>
                        </div>
                    ';
                }
            }
        } else {
            $output .= '
            <a class="dropdown-item" href="javascript:;">
                <div class="notification-content">
                    <i class="fas fa-info-circle text-info"></i>
                    <div class="notification-text">
                        Belum ada notifikasi
                        <br>
                    </div>
                </div>
            </a>
            ';
        }

        Auth::user()->unreadNotifications->markAsRead();
        return response()->json([
            'notifications' => $output,
        ]);

        return response()->json([
            'notifications' => $output,
        ]);
    }
}
