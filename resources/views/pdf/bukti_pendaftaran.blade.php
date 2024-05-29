<!DOCTYPE html>
<html>
<head>
    <title>Bukti Pendaftaran</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { text-align: left; }
    </style>
</head>
<body>
    <h2>Bukti Pendaftaran</h2>
    <p>Tanggal Transaksi: {{ $transaksi->tanggal_transaksi }}</p>
    <p>ID Transaksi: {{ $transaksi->id }}</p>
    <p>Penanggung Jawab: {{ $pendaftaran->dataPeserta->user->nama }}</p>
    <p>Nama Peserta: {{ $pendaftaran->dataPeserta->nama_lengkap_peserta }}</p>
    <p>Metode Pembayaran: {{ $pendaftaran->metode_pembayaran }}</p>
    <p>Status Pembayaran: {{ $transaksi->status_pembayaran }}</p>
    <h4>Detail Program</h4>
    <table>
        <thead>
            <tr>
                <th>Jenis Program</th>
                <th>Tanggal</th>
                <th>Tipe</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($programs as $program)
            <tr>
                <td>{{ $program->nama_program }}</td>
                <td>{{ \Carbon\Carbon::parse($program->pivot->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $program->pivot->tipe }}</td>
                <td>{{ number_format($program->pivot->harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3">Total Harga</td>
                <td>{{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
