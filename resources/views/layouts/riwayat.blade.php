@extends('layouts.mainlayout')
@section('title', 'Riwayat Pendaftaran')
@section('content6')
<div class="container">
    <div class="d-flex justify-content-between align-items-center text-success">
        <h1 class="display-6 text-success">Riwayat<br>Pendaftaran Program</h1>
        <button class="btn btn-secondary" onclick="location.href='{{ route('home') }}';">
            <i class="bi bi-arrow-left"></i>
        </button>
    </div>
        @include('layouts.pesan')

        @if ($pendaftaran->isEmpty())
            <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                <h2 class="text-center">Belum ada riwayat pendaftaran. Silahkan lakukan pendaftaran.</h2>
            </div>
        @else
            @foreach ($pendaftaran as $daftar)
            <div class="card mb-3">
                <div class="card-header text-white bg-success">
                    <h1 class="display-6">{{ $daftar->program->first()->nama_program }}</h1>
                </div>
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 ">Status Pendaftaran:
                        @if ($daftar->status_pendaftaran == 'Baru')
                            <span class="badge bg-primary">Baru</span>
                        @elseif($daftar->status_pendaftaran == 'Ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @elseif($daftar->status_pendaftaran == 'Dibatalkan')
                            <span class="badge bg-danger">Dibatalkan</span>
                        @elseif($daftar->status_pendaftaran == 'Menunggu Jadwal')
                            <span class="badge bg-warning">Menunggu Jadwal</span>
                        @elseif($daftar->status_pendaftaran == 'Diterima')
                            <span class="badge bg-success">Diterima</span>
                        @endif
                    </h6>
                    <h6 class="card-subtitle mb-2 ">Metode Pembayaran: {{ $daftar->metode_pembayaran }}</h6>
                    <p class="card-text text-secondary">Pendaftaran ID: {{ $daftar->id }}</p>

                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Tipe</th>
                                <th scope="col">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($daftar->program as $program)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($program->pivot->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ $program->pivot->tipe }}</td>
                                <td>{{ number_format($program->pivot->harga, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <p class="card-text"><strong>Total Harga: {{ number_format($daftar->transaksi->total_harga, 0, ',', '.') }}</strong></p>
                    <h6 class="card-subtitle mb-2 text-muted">Status Pembayaran:
                        @if ($daftar->transaksi->status_pembayaran == 'Lunas')
                            <span class="badge bg-success">Lunas</span>
                        @elseif($daftar->transaksi->status_pembayaran == 'Lunas')
                            <span class="badge bg-danger">Belum Lunas</span>
                        @else
                            <span class="badge bg-warning">Menunggu Verifikasi Admin</span>
                        @endif
                    </h6>
                </div>
            </div>
            @endforeach
        @endif
</div>
@endsection
