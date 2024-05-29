@extends('layouts.mainlayout')
@section('title', 'Daftar')
@section('content5')
<div class="container">
    <div class="">
        <h1 class="display-6 text-success">Tagihan<br>Pembayaran Program</h1>
        @include('layouts.pesan')
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Jenis Program</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Tipe</th>
                            <th scope="col">Harga</th>
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
                            <td colspan="2"></td>
                            <th>Total Harga</th>
                            <th>{{ number_format($transaksi->total_harga, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <th>Metode Pembayaran</th>
                            <th>{{ $pendaftaran->metode_pembayaran }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>  
        </div>
            <div class="row my-3">
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-header text-center ">
                            <h4>Tata Cara Pembayaran</h4>
                        </div>
                        <div class="card-body">
                            <p>Metode Pembayaran: Tunai </p>
                            <li>Klik Cetak Bukti Pendaftaran untuk menyimpan data pendaftaran.</li> 
                            <li>Simpan untuk unduh bukti dan bawa saat datang ke Yayasan.</li> <br>
                            <p>Metode Pembayaran: Transfer BRI </p>
                            <li>Klik Upload Bukti Pembayaran.</li> 
                            <li>Upload Bukti Pembayaran.</li> 
                          
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-4 offset-lg-2">
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-success w-100 ms-2 me-2">
                            Status Pembayaran
                        </button>
                        @if ($transaksi->status_pembayaran == 'Lunas')
                            <button type="button" class="btn btn-success w-100 ms-2">
                                Lunas
                            </button>
                        @else
                            <button type="button" class="btn btn-danger w-100 ms-2">
                                Belum Lunas
                            </button>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        @if ($pendaftaran->metode_pembayaran == 'Tunai')
                            <a href="{{ route('cetakBuktiPendaftaran', ['id' => $pendaftaran->id]) }}" class="btn btn-primary w-100 ms-2">
                                Cetak Bukti Pendaftaran
                            </a>
                        @elseif ($pendaftaran->metode_pembayaran == 'Transfer BRI')
                            <form action="{{ route('uploadBuktiPembayaran', ['id' => $pendaftaran->id]) }}" method="post" enctype="multipart/form-data" class="w-100 ms-2">
                                @csrf
                                <input type="file" name="bukti_pembayaran" class="form-control mb-2" required>
                                <button type="submit" class="btn btn-primary w-100">Upload Bukti Pembayaran</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
    </div>
</div>

@endsection