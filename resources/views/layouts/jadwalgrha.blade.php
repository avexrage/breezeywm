@extends('layouts.mainlayout')
@section('title', 'Pendaftaran Grha Wredha Mulya')
@section('content8')

<div class="container">
    <div class="d-flex justify-content-between align-items-center text-success">
        <h1 class="display-6">Jadwal Program<br>Grha Wredha Mulya</h1>
        <button class="btn btn-secondary" onclick="goBack()">
            <i class="bi bi-arrow-left"></i> Kembali
        </button>
    </div>
    @include('layouts.pesan')
{{-- @if (session()->has('form1_data'))
@json(session('form1_data'))
@else
    Tidak ada data dalam session
@endif --}}
    <div class="card">
        <h5 class="card-header text-center text-success bg-success text-white">
            Pilih Metode Pembayaran
        </h5>
        <div class="card-body">
             
        </div>
    </div>

</div>
@endsection

<script>
    function goBack() {
        window.history.back();
    }
</script>
