@extends('layouts.mainlayout')
@section('title', 'Upload Video Mandiri')
@section('content7')

<div class="container">
    <div class="d-flex justify-content-between align-items-center text-success">
        <h1 class="display-6">Upload Video<br>Kemandirian Lansia</h1>
        <button class="btn btn-secondary" onclick="goBack()">
            <i class="bi bi-arrow-left"></i>
        </button>
    </div>
    @include('layouts.pesan')
    <!-- START FORM -->
    <div>
        <form action="{{ route('simpanvideo') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 p-3 bg-body rounded shadow-sm">
                <div class="mb-3 row">
                    <label for="video" class="col-sm-12 col-form-label">Upload Video</label>
                    <div class="col-sm-12">
                        <input type="file" class="form-control @error('video') is-invalid @enderror" name="video" id="video" accept="video/*">
                        @error('video')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-sm-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
                </div>
            </div>
        </form>    
    </div>
    <!-- Informasi Video -->
    <div class="card my-3 shadow-sm" style="border: none">
        <div class="card-header bg-success text-white">
            <h4>Panduan Membuat Video Kemandirian Lansia</h4>
        </div>
        <div class="card-body">
            <ul>
                <li>Durasi video maksimal 1 menit.</li>
                <li>Video mencakup aktivitas sehari-hari seperti makan, minum, berkebun, jalan - jalan atau lainnya.</li>
                <li>Pastikan video diambil dalam satu kali pengambilan (one take), tanpa perlu pengeditan.</li>
                <li>Pastikan kualitas video cukup jelas sehingga kegiatan dapat terlihat dengan baik.</li>
                <li>Format video yang diperbolehkan: mp4, mov, avi, wmv.</li>
                <li>Ukuran video maksimal 20MB.</li>
            </ul>
        </div>
    </div>
</div>
@endsection

<script>
    function goBack() {
        window.history.back();
    }
</script>
