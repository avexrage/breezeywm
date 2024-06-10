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
        .program-details {
            margin-top: 10px;
        }
        .program-details th, .program-details td {
            padding: 5px;
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
                <th>Tanggal</th>
                <th>Harga</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groupedData as $data)
                @foreach ($data['program_details'] as $index => $detail)
                    <tr>
                        @if ($index == 0)
                            <td rowspan="{{ count($data['program_details']) }}">{{ $data['nama_lengkap_peserta'] }}</td>
                            <td rowspan="{{ count($data['program_details']) }}">{{ $data['nama_asuransi'] }}</td>
                            <td rowspan="{{ count($data['program_details']) }}">{{ $data['no_asuransi'] }}</td>
                            <td rowspan="{{ count($data['program_details']) }}">{{ \Carbon\Carbon::parse($data['tanggal_daftar'])->format('d-m-Y') }}</td>
                            <td rowspan="{{ count($data['program_details']) }}" class="status">
                                {{ $data['status_pendaftaran'] }}
                            </td>
                        @endif
                        <td>{{ \Carbon\Carbon::parse($detail['tanggal'])->format('d-m-Y') }}</td>
                        <td>{{ $detail['harga'] }}</td>
                        <td>{{ $detail['waktu'] }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
