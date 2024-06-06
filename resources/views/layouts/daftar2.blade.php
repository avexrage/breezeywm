@extends('layouts.mainlayout')
@section('title', 'Daftar')
@section('content7')

<div class="container">
    @include('layouts.pesan')
    <div class="d-flex justify-content-between align-items-center text-success">
        <h1 class="display-6">Daftar Program<br>Grha Wredha Mulya</h1>
        <button class="btn btn-secondary" onclick="goBack()">
            <i class="bi bi-arrow-left"></i>
        </button>
    </div>
{{-- @if (session()->has('form1_data'))
@json(session('form1_data'))
@else
    Tidak ada data dalam session
@endif --}}
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="card shadow-sm" style="border: none">
                <h5 class="card-header text-center text-success bg-success text-white">
                    Pemilihan Tipe Rumah dan Lama Program 
                </h5>
                <div class="card-body">    
                    <!-- Radio buttons as button groups -->
            <form action="{{ route('daftargrha') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="btn-group" role="group" aria-label="Tipe Rumah">
                        <input type="radio" class="btn-check" name="program" id="tipeRumahA" value="21" autocomplete="off">
                        <label class="btn btn-outline-success" for="tipeRumahA">Tipe Rumah A</label>
    
                        <input type="radio" class="btn-check" name="program" id="tipeRumahB" value="22" autocomplete="off">
                        <label class="btn btn-outline-success" for="tipeRumahB">Tipe Rumah B</label>
                    </div>
    
                    <!-- Dropdown for program duration -->
                    <div class="mt-3">
                        <label for="programDuration" class="form-label">Lama Program</label>
                        <div class="input-group">
                            <select class="form-select" id="programDuration" name="durasi">
                                <option disabled selected >Pilih Lama Program</option>
                                <option value="1">1 Tahun</option>
                                <option value="2">2 Tahun</option>
                                <option value="3">3 Tahun</option>
                                <option value="4">4 Tahun</option>
                                <option value="5">5 Tahun</option>
                            </select>
                            {{-- <span class="input-group-text"><i class="bi bi-chevron-down"></i></span> --}}
                        </div>
                    </div>
                    <div class="my-3 row">
                        <label for="video" class="col-sm-12 col-form-label">Upload Video Bukti Kemandirian Lansia</label>
                        <div class="col">
                            <input type="file" class="form-control @error('video') is-invalid @enderror" name="video" id="video" accept="video/*">
                            @error('video')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col">
                            <button type="submit" class="btn btn-success">Daftar</button>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
        <div class="col-lg-7 offset-lg-1 text-success">
            <div style="font-size: 30px;">Daftar Harga</div>
            <div class="card shadow-sm" style="border: none">
                {{-- <h5 class="card-header text-center text-success bg-success text-white">
                    Daftar Harga
                </h5> --}}
                <div class="card-body rounded bg-success text-white shadow-sm">
                    <div class="row">
                        <div class="col-4">
                            <h5 class="card-subtitle">Program</h5>
                        </div>
                        <div class="col-4">
                            <h5 class="card-subtitle">Tipe Rumah</h5>
                        </div>
                        <div class="col-4">
                            <h5 class="card-subtitle">Harga</h5>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4">
                            <p class="card-subtitle">Grha Wredha Mulya</p>
                        </div>
                        <div class="col-4">
                            <p class="card-subtitle">Tipe Rumah A</p>
                        </div>
                        <div class="col-4">
                            <p class="card-subtitle">Rp. 17.500.000 / Tahun</p>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-4">
                            <p class="card-subtitle">Grha Wredha Mulya</p>
                        </div>
                        <div class="col-4">
                            <p class="card-subtitle">Tipe Rumah B</p>
                        </div>
                        <div class="col-4">
                            <p class="card-subtitle">Rp. 20.000.000 / Tahun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Video -->
    <div class="card my-3 shadow-sm" style="border: none">
        <h5 class="card-header text-success bg-success text-white">
            Panduan Membuat Video Kemandirian Lansia 
        </h5>
        <div class="card-body">
            <ul>
                <li>Durasi video maksimal 1 menit.</li>
                <li>Video mencakup aktivitas mandiri sehari-hari seperti makan, minum, berkebun, jalan - jalan atau lainnya.</li>
                <li>Pastikan video diambil dalam satu kali pengambilan (one take), tanpa perlu pengeditan.</li>
                <li>Pastikan kualitas video cukup jelas sehingga lansia dapat terlihat dengan baik.</li>
                <li>Format video yang diperbolehkan: mp4, mov, avi, wmv.</li>
                <li>Ukuran video maksimal 20MB.</li>
            </ul>
        </div>
    </div>
</div>

<script>
function goBack() {
    window.history.back();
}
</script>
@endsection