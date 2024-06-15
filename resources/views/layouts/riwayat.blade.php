@extends('layouts.mainlayout')
@section('title', 'Riwayat Pendaftaran')
@section('content6')
<div class="container">
    <div class="d-flex justify-content-between align-items-center text-success">
        <h1 class="display-6">Riwayat <br> Pendaftaran Program</h1>
        <button class="btn btn-secondary" onclick="location.href='{{ route('home') }}';">
            <i class="bi bi-arrow-left"></i> Kembali
        </button>
    </div>
    @include('layouts.pesan')
    @if ($pendaftaran->isEmpty())
        <div class="card mb-3 text-center shadow-sm" style="border: none">
            <div class="card-header py-3 bg-success text-white">
                <h1 class="display-6">Tidak Ada Riwayat Pendaftaran</h1>
            </div>
            <div class="card-body">
                <p class="card-text text-success">Klik Disini Untuk Mendaftar</p>
                <a href="{{ route('daftar') }}" class="btn btn-outline-success">Daftar</a>
            </div>
        </div>
    @else
        @foreach ($pendaftaran as $daftar)
            <div class="card mb-3 shadow-sm" style="border: none">
                <div class="card-header text-white bg-success">
                    <h1 class="display-6">{{ $daftar->program->first()->nama_program }}</h1>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-2 d-flex align-items-center">
                                <p class="card-text text-center"><strong>Status Pendaftaran</strong></p>
                            </div>
                            <div class="col-md-6 d-flex align-items-center">:&nbsp;
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
                            </div>
                            <div class="col-md-4 d-flex align-items-center justify-content-end">
                                <p class="card-text text-center"><strong>Tanggal Masuk:
                                @if(isset($daftar->check_in))
                                    {{ \Carbon\Carbon::parse($daftar->check_in)->format('d-m-Y') }}
                                @else
                                    -
                                @endif</strong></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 d-flex align-items-center">
                                <p class="card-text text-center"><strong>Metode Pembayaran</strong></p>
                            </div>
                            <div class="col-md-6 d-flex align-items-center">:&nbsp;
                                @if(isset($daftar->metode_pembayaran))
                                    {{ $daftar->metode_pembayaran }}
                                @else
                                    -
                                @endif
                            </div>
                            <div class="col-md-4 d-flex align-items-center justify-content-end">
                                <p class="card-text text-center"><strong>Tanggal Keluar:
                                @if(isset($daftar->check_out))
                                    {{ \Carbon\Carbon::parse($daftar->check_out)->format('d-m-Y') }}
                                @else
                                    -
                                @endif</strong></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 d-flex align-items-center">
                                <p class="card-text text-center"><strong>Pendaftaran ID</strong></p>
                            </div>
                            <div class="col-md-6 d-flex align-items-center justify-content-start">:&nbsp;
                                <p class="card-text text-center">{{ $daftar->id }}</p>
                            </div>
                            <div class="col-md-4 d-flex align-items-center justify-content-end">
                                @foreach ($daftar->program as $program)
                                    @if ($program->nama_program == 'Grha Wredha Mulya')
                                        <p class="card-text text-center"><strong>Lama Program: {{ $program->pivot->durasi }} Tahun</strong></p>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 d-flex align-items-center">
                                <p class="card-text text-center"><strong>Nama Peserta</strong></p>
                            </div>
                            <div class="col-md-10 d-flex align-items-center">:&nbsp;
                                <p class="card-text text-center">{{ $daftar->peserta->nama_lengkap_peserta }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 d-flex align-items-center">
                                @if ($daftar->status_pendaftaran == 'Ditolak')
                                    <p class="card-text text-center"><strong>Alasan</strong></p>
                                @endif
                            </div>
                            <div class="col-md-10 d-flex align-items-center">
                                @if ($daftar->status_pendaftaran == 'Ditolak')
                                    <p class="card-text text-center">:&nbsp;{{ $daftar->alasan }}</p>
                                @endif
                            </div>
                            @if ($daftar->status_pendaftaran == 'Diterima')
                                @php
                                    $showButton = false;
                                    $statusPembayaran = isset($daftar->transaksi) ? $daftar->transaksi->status_pembayaran : null;
                                    
                                    foreach ($daftar->program as $program) {
                                        if (in_array($program->id_program, [21, 22])) {
                                            // Jika status pembayaran adalah 'Lunas', jangan tampilkan tombol
                                            if ($statusPembayaran !== 'Lunas') {
                                                $showButton = true;
                                            }
                                        }
                                    }
                                @endphp
                                <div class="col-md-6">
                                    @if ($showButton)
                                        <button class="btn btn-primary text-white mt-2 w-100" data-bs-toggle="modal" data-bs-target="#paymentModal{{ $daftar->id }}"><strong>Lanjutkan Pembayaran</strong></button>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    @if ($showButton)
                                        <button class="btn btn-danger text-white mt-2 w-100" data-bs-toggle="modal" data-bs-target="#confirmCancelModal{{ $daftar->id }}"><strong>Batalkan Pembayaran</strong></button>
                                    @endif
                                </div>
                            @elseif($daftar->status_pendaftaran == 'Baru')
                                @php
                                    $showButton = false;

                                    foreach ($daftar->program as $program) {
                                        if (in_array($program->id_program, [21, 22])) {
                                            
                                            $showButton = true;
                                        }
                                    }
                                @endphp
                                <div class="col">
                                    @if ($showButton)
                                        <button class="btn btn-secondary text-white mt-2 w-100"><strong>Menunggu Admin Verifikasi Kemandirian Lansia</strong></button>
                                    @endif
                                </div>
                            @elseif($daftar->status_pendaftaran == 'Menunggu Jadwal')
                                @php
                                    $showButton = false;

                                    foreach ($daftar->program as $program) {
                                        if (in_array($program->id_program, [21, 22])) {
                                            
                                            $showButton = true;
                                        }
                                    }
                                @endphp
                                <div class="col">
                                    @if ($showButton)
                                        <button class="btn btn-warning text-white mt-2 w-100"><strong>Menunggu Jadwal Mulai Masuk Program</strong></button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    <table class="table mt-3 table-striped table-responsive">
                        <thead>
                            <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Tipe</th>
                                <th scope="col" class="text-end">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($daftar->program as $program)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($program->pivot->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ $program->pivot->tipe }}</td>
                                    <td class="text-end">{{ number_format($program->pivot->harga, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p class="card-text text-end"><strong>Total Harga: 
                        @if (isset($daftar->transaksi) && !is_null($daftar->transaksi->total_harga))
                            {{ number_format($daftar->transaksi->total_harga, 0, ',', '.') }}
                        @else
                            -
                        @endif
                        </strong></p>
                    <h6 class="card-subtitle mb-2 text-muted text-end">Status Pembayaran:
                        @if (isset($daftar->transaksi))
                            @if ($daftar->transaksi->status_pembayaran == 'Lunas')
                                <span class="badge bg-success">Lunas</span>
                            @elseif($daftar->transaksi->status_pembayaran == 'Belum Lunas')
                                <span class="badge bg-danger">Belum Lunas</span>
                            @else
                                <span class="badge bg-warning">Menunggu Verifikasi Admin</span>
                            @endif
                        @else
                            <span class="badge bg-secondary">-</span>
                        @endif
                    </h6>
                </div>
            </div>
            <!-- Modal Lanjutkan Pembayaran-->
            <div class="modal fade" id="paymentModal{{ $daftar->id }}" tabindex="-1" aria-labelledby="paymentModalLabel{{ $daftar->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('pilihmetode', $daftar->id) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="paymentModalLabel{{ $daftar->id }}">Pilih Metode Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label class="form-label" for="metodePembayaran">Metode Pembayaran</label>
                                <select class="form-control" id="metodePembayaran" name="metodePembayaran" required>
                                    <option value="" disabled selected>Pilih Pembayaran</option>
                                    <option value="Tunai">Tunai</option>
                                    <option value="Transfer BRI">Transfer BRI</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Pilih</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Confirm Cancel Modal -->
            <div class="modal fade" id="confirmCancelModal{{ $daftar->id }}" tabindex="-1" aria-labelledby="confirmCancelModalLabel{{ $daftar->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmCancelModalLabel{{ $daftar->id }}">Konfirmasi Pembatalan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin membatalkan pembayaran? Jika Anda membatalkan, maka pendaftaran akan dibatalkan.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                            <a href="{{ route('batalkanPendaftaran', $daftar->id) }}" class="btn btn-danger">Ya, Batalkan</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
