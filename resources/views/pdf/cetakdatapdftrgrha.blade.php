<!DOCTYPE html>
<html>
<head>
    <title>Data Pendaftaran Day Care</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table, .table th, .table td {
            border: 1px solid black;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
        }

    </style>
</head>
<body>
    <div class="header">
        <h1>Data Pendaftaran Day Care</h1>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Nama Peserta</th>
                <th>Nama Asuransi</th>
                <th>Nomor Asuransi</th>
                <th>Tanggal Daftar</th>
                <th>Status Pendaftaran</th>
                <th>Durasi</th>
                <th>Tanggal Masuk Program</th>
                <th>Tanggal Keluar Program</th>
                <th>Wisma</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($pendaftaranGrha as $data)
                    <tr>
                        <td>{{ $data->nama_lengkap_peserta }}</td>
                        <td>{{ $data->nama_asuransi }}</td>
                        <td>{{ $data->no_asuransi }}</td>
                        <td>{{ $data->tanggal_daftar ? \Carbon\Carbon::parse($data->check_in )->format('d/m/Y') : '-' }}</td>
                        <td>{{ $data->status_pendaftaran }}</td>
                        <td>{{ $data->durasi }}</td>
                        <td>{{ $data->check_in ? \Carbon\Carbon::parse($data->check_in )->format('d/m/Y') : '-' }}</td>
                        <td>{{ $data->check_out ? \Carbon\Carbon::parse($data->check_out )->format('d/m/Y') : '-' }}</td>
                        <td>{{ $data->wisma }}</td>
                    </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
