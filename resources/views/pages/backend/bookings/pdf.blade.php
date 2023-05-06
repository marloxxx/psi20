<html>

<head>
    <title>Data Pemesanan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <center>
        <h5>Laporan Data Pemesanan</h5>
    </center>
    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Pemesanan</th>
                <th>Nama Pemesan</th>
                <th>Nama Penginapan</th>
                <th>Tanggal Checkin</th>
                <th>Tanggal Checkout</th>
                <th>Total Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookings as $booking)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $booking->code }}</td>
                    <td>{{ $booking->user->first_name }} {{ $booking->user->last_name }}</td>
                    <td>{{ $booking->homestay->name }}</td>
                    <td>{{ $booking->check_in }}</td>
                    <td>{{ $booking->check_out }}</td>
                    <td>Rp. {{ number_format($booking->total_price) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
