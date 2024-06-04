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
    @if ($pendaftaran->isEmpty() && $dataPesertaWithVideos->isEmpty())
    <div class="card mb-3 text-center text-white shadow-sm" style="border: none">
        <div class="card-header py-3 bg-success">
            <h1 class="display-6">Tidak Ada Riwayat Pendaftaran</h1>
        </div>
        <div class="card-body" style="border: none">
            <p class="card-text text-success">Klik Disini Untuk Mendaftar</p>
            <a href="{{ route('daftar') }}" class="btn btn-outline-success">Daftar</a>
        </div>
    </div>
    @else
    @foreach ($dataPesertaWithVideos as $dataPeserta)
    <div class="card mb-3">
        <div class="card-header text-white bg-success">
            <h1 class="display-6">Grha Wredha Mulya</h1>
        </div>
        <div class="card-body">
            <h6 class="card-subtitle mb-2">Status Pendaftaran:
                @if ($dataPeserta->pendaftaran && $dataPeserta->pendaftaran->status_pendaftaran == 'Menunggu Jadwal')
                    <span class="badge bg-warning">Menunggu Jadwal</span>
                    <a href="{{ route('showDaftar2') }}" class="btn btn-primary mt-2">Lanjutkan Pendaftaran</a>
                @elseif ($dataPeserta->pendaftaran && $dataPeserta->pendaftaran->status_pendaftaran == 'Ditolak')
                    <span class="badge bg-danger">Ditolak</span>
                    <p>Alasan: {{ $dataPeserta->pendaftaran->alasan }}</p>
                @elseif ($dataPeserta->pendaftaran && $dataPeserta->pendaftaran->status_pendaftaran == 'Diterima')
                    <span class="badge bg-success">Diterima</span>
                @else
                    <span class="badge bg-primary">Baru</span>
                @endif
            </h6>
            <p class="card-text text-secondary">Nama Peserta: {{ $dataPeserta->nama_lengkap_peserta }} <br> Nomor KTP: {{ $dataPeserta->ktp }}</p>
            <h6 class="card-subtitle">Jika lansia terverifikasi lansia mandiri maka Status Pendaftaran akan menjadi Menunggu Jadwal. Harap menunggu Verifikasi Admin maksimal 1 x 24 jam. Cek Riwayat Pendaftaran secara berkala</h6>
            <!-- Additional data as needed -->
        </div>
    </div>
    @endforeach
    @foreach ($pendaftaran as $daftar)
    <div class="card mb-3">
        <div class="card-header text-white bg-success">
            <h1 class="display-6">{{ $daftar->program->first()->nama_program }}</h1>
        </div>
        <div class="card-body">
            <h6 class="card-subtitle mb-2">Status Pendaftaran:
                @if ($daftar->status_pendaftaran == 'Baru')
                    <span class="badge bg-primary">Baru</span>
                @elseif($daftar->status_pendaftaran == 'Ditolak')
                    <span class="badge bg-danger">Ditolak</span>
                    <p>Alasan: {{ $daftar->alasan }}</p>
                @elseif($daftar->status_pendaftaran == 'Dibatalkan')
                    <span class="badge bg-danger">Dibatalkan</span>
                @elseif($daftar->status_pendaftaran == 'Menunggu Jadwal')
                    <span class="badge bg-warning">Menunggu Jadwal</span>
                    <a href="{{ route('showDaftar2') }}" class="btn btn-primary mt-2">Lanjutkan Pendaftaran</a>
                @elseif($daftar->status_pendaftaran == 'Diterima')
                    <span class="badge bg-success">Diterima</span>
                @endif
            </h6>
            <h6 class="card-subtitle mb-2">Metode Pembayaran: {{ $daftar->metode_pembayaran }}</h6>
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
            
            <p class="card-text text-end"><strong>Total Harga: {{ number_format($daftar->transaksi->total_harga, 0, ',', '.') }}</strong></p>
            <h6 class="card-subtitle mb-2 text-muted text-end">Status Pembayaran:
                @if ($daftar->transaksi->status_pembayaran == 'Lunas')
                    <span class="badge bg-success">Lunas</span>
                @elseif($daftar->transaksi->status_pembayaran == 'Belum Lunas')
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
