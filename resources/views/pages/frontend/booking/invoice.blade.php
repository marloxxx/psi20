<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {!! SEO::generate(true) !!}
    <link rel="icon" href="{{ asset('images/' . getSettings('site_favicon')) }}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{ asset('images/' . getSettings('site_favicon')) }}" type="image/x-icon" />
    <script src="https://kit.fontawesome.com/07ad57e463.js" crossorigin="anonymous"></script>
    <!-- GOOGLE WEB FONT -->
    <link
        href="https://fonts.googleapis.com/css2?family=Gochi+Hand&amp;family=Montserrat:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet">

    <!-- COMMON CSS -->
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/vendors.css') }}" rel="stylesheet">
    <style>
        .invoice-title h2,
        .invoice-title h3 {
            display: inline-block;
        }

        .table>tbody>tr>.no-line {
            border-top: none;
        }

        .table>thead>tr>.no-line {
            border-bottom: none;
        }

        .table>tbody>tr>.thick-line {
            border-top: 2px solid;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="invoice-title">
                    <h2>Tagihan</h2>
                    <h3 class="float-end">Pesanan #{{ $booking->Code }}</h3>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <address>
                            <strong>Tagihan Kepada:</strong><br>
                            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}<br>
                            {{ Auth::user()->phone_number }}<br>
                        </address>
                    </div>
                    <div class="col-6 text-end">
                        <address>
                            <strong>Tanggal Pemesanan:</strong><br>
                            {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}<br><br>
                            <br><br>
                        </address>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Rincian Pesanan</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <td><strong>Penginapan</strong></td>
                                        <td class="text-center"><strong>Harga</strong></td>
                                        <td class="text-center"><strong>Malam</strong></td>
                                        <td class="text-end"><strong>Total</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                    <tr>
                                        <td>{{ $booking->homestay->name }}</td>
                                        <td class="text-center">Rp.
                                            {{ number_format($booking->homestay->price, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out) }}
                                        </td>
                                        <td class="text-end">Rp.
                                            {{ number_format($booking->total_price, 0, ',', '.') }}
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-center"><strong>Total</strong></td>
                                        <td class="no-line text-end">Rp.
                                            {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
