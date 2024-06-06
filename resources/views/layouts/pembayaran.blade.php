@extends('layouts.mainlayout')
@section('title', 'Tagihan Pembayaran')
@section('content5')
<div class="container">
    <div class="d-flex justify-content-between align-items-center text-success">
        <h1 class="display-6">Tagihan<br>Pembayaran Program</h1>
        <button class="btn btn-secondary" onclick="location.href='{{ route('home') }}';">
            <i class="bi bi-arrow-left"></i> Kembali
        </button>
    </div>
    @include('layouts.pesan')
    @if (!$unpaidTransactions)
        <div class="card mb-3 text-center text-white shadow-sm" style="border: none">
            <div class="card-header py-3 bg-success">
                <h1 class="display-6">Tidak Ada Tagihan Pembayaran</h1>
            </div>
            <div class="card-body" style="border: none">
                <p class="card-text text-success">Jika Sudah Mendaftar, Cek Status Pendaftaran Disini</p>
                <a href="{{ route('riwayat') }}" class="btn btn-outline-success">Riwayat Pendaftaran</a>
            </div>
        </div>
    @else
        @foreach ($unpaidTransactions as $unpaid)
            @if (!is_null($unpaid['pendaftaran']->metode_pembayaran))
                <div class="card mb-3 shadow-sm" style="border: none">
                    <div class="card-header text-white bg-success">
                        <h1 class="display-6">{{ $unpaid['nama_program'] }}</h1>
                    </div>
                    <div class="card-body">
                        <div class="container">   
                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center">
                                    <p class="card-text text-center"><strong>Tanggal Pendaftaran</strong></p> 
                                </div>
                                <div class="col-md-6 d-flex align-items-center">:&nbsp;
                                    <p class="card-text text-center"><strong>{{ $unpaid['pendaftaran']->created_at->format('d-m-Y') }}</strong></p>
                                </div>
                                <div class="col-md-4 d-flex align-items-center justify-content-end">
                                    <p class="card-text text-center"><strong>Tanggal Masuk : 
                                        @if(isset($unpaid['check_in']))
                                        {{ \Carbon\Carbon::parse($unpaid['check_in'])->format('d-m-Y') }}</p>
                                        @else
                                        -
                                        @endif</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 d-flex align-items-center">
                                    <p class="card-text text-center"><strong>Pendaftaran ID</strong></p> 
                                </div>
                                <div class="col-md-6 d-flex align-items-center">:&nbsp;
                                    <p class="card-text text-center"><strong>{{ $unpaid['pendaftaran']->id }}</strong></p>
                                </div>
                                <div class="col-md-4 d-flex align-items-center justify-content-end">
                                    <p class="card-text text-center"><strong>Tanggal Keluar : 
                                        @if(isset($unpaid['check_out']))
                                        {{ \Carbon\Carbon::parse($unpaid['check_out'])->format('d-m-Y') }}</p>
                                        @else
                                        -
                                        @endif</strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 d-flex align-items-center">
                                    <p class="card-text text-center"><strong>Nama Peserta</strong></p> 
                                </div>
                                <div class="col-md-6 d-flex align-items-center">:&nbsp;
                                    <p class="card-text text-center"><strong> {{$unpaid['nama_lengkap_peserta']}}</strong></p>
                                </div>
                                <div class="col-md-4 d-flex align-items-center justify-content-end">
                                    @if ($unpaid['nama_program'] == 'Grha Wredha Mulya')
                                        @if (isset($unpaid['durasi']))
                                            <p class="card-text text-center"><strong>Lama Program: {{ $unpaid['durasi'] }} Tahun</strong></p>
                                        @else
                                        @endif
                                    @endif
                                </div>
                                
                            </div>
                            <table class="table mt-3 table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th scope="col">Tanggal Program</th>
                                        <th scope="col" class="text-start">Tipe</th>
                                        <th scope="col" class="text-end">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($unpaid['programs'] as $program)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($program->pivot->tanggal)->format('d-m-Y') }}</td>
                                        <td class="text-start">{{ $program->pivot->tipe }}</td>
                                        <td class="text-end">{{ number_format($program->pivot->harga, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-lg-2 offset-lg-8 text-start ">
                                    <strong>Total Harga</strong></td>
                                </div>
                                <div class="col-lg-2 text-start ">
                                    <p class="text-end"><strong>{{ number_format($unpaid['transaksi']->total_harga, 0, ',', '.') }}</strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2 offset-lg-8 text-start">
                                   <p> <strong>Metode Pembayaran</strong></p>
                                </div>
                                <div class="col-lg-2 text-end">
                                    @if(isset($unpaid['pendaftaran']->metode_pembayaran))
                                        <p class="text-end"><strong>{{ $unpaid['pendaftaran']->metode_pembayaran }}</p>
                                    @else
                                        -
                                    @endif</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row my-3">
                    <div class="col-lg-4 col-md-6">
                        <div class="card" style="border: none">
                            <button class="btn btn-success w-100" data-bs-toggle="collapse" href="#collapsePaymentGuide{{ $loop->index }}" role="button" aria-expanded="false" aria-controls="collapsePaymentGuide{{ $loop->index }}">
                                Tata Cara Pembayaran <i class="bi bi-chevron-down"></i>
                            </button>
                            <div class="collapse mt-2   " id="collapsePaymentGuide{{ $loop->index }}">
                                <div class="card card-body">
                                    <p><strong>Metode Pembayaran: Tunai</strong></p>
                                    <ul>
                                        <li>Klik Cetak Bukti Pendaftaran untuk menyimpan data pendaftaran.</li>
                                        <li>Simpan untuk unduh bukti dan bawa saat datang ke Yayasan.</li>
                                    </ul>
                                    <p><strong>Metode Pembayaran: Transfer BRI</strong></p>
                                    <ul>
                                        <li>Klik Choose File dan pilih foto bukti transfer.</li>
                                        <li>Klik Upload Bukti Pembayaran.</li>
                                        <li>Tunggu Verifikasi pembayaran dari admin.</li>
                                        <li>Jika Pembayaran sudah terverifikasi, cek riwayat pendaftaran di menu profil.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-4 offset-lg-2">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-success w-100 ms-2 me-2">
                                Status Pembayaran
                            </button>
                            @if ($unpaid['transaksi']->status_pembayaran == 'Lunas')
                                <button type="button" class="btn btn-success w-100 ms-2">
                                    Lunas
                                </button>
                            @elseif ($unpaid['transaksi']->status_pembayaran == 'Menunggu Verifikasi Admin')
                                <button type="button" class="btn btn-warning w-100 ms-2">
                                    Menunggu Verifikasi Admin
                                </button>
                            @else
                                <button type="button" class="btn btn-danger w-100 ms-2">
                                    Belum Lunas
                                </button>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            @if ($unpaid['pendaftaran']->metode_pembayaran == 'Tunai')
                                <a href="{{ route('cetakBuktiPendaftaran', ['id' => $unpaid['pendaftaran']->id]) }}" class="btn btn-primary w-100 ms-2">
                                    Cetak Bukti Pendaftaran
                                </a>
                            @elseif ($unpaid['pendaftaran']->metode_pembayaran == 'Transfer BRI')
                                <form action="{{ route('uploadBuktiPembayaran', ['id' => $unpaid['pendaftaran']->id]) }}" method="post" enctype="multipart/form-data" class="w-100 ms-2">
                                    @csrf
                                    <input type="file" name="bukti_pembayaran" class="form-control mb-2" required>
                                    <button type="submit" class="btn btn-primary w-100">Upload Bukti Pembayaran</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif
</div>
@endsection
