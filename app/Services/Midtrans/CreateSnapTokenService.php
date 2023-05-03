<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $booking;

    public function __construct($booking)
    {
        parent::__construct();

        $this->booking = $booking;
    }

    public function getSnapToken()
    {
        $params = [
            'transaction_details' => [
                'order_id' => $this->booking->code,
                'gross_amount' => $this->booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $this->booking->user->name,
                'email' => $this->booking->user->email,
                'phone' => $this->booking->user->phone,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return $snapToken;
    }
}
