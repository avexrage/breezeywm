@extends('layouts.mainlayout')
@section('title', 'Daftar')
@section('content4')

<div class="container">
    @include('layouts.pesan')
    <h1 class="display-6">
    Daftar Program<br>
    Day Care</h1>
        <div class="row">
            <div class="col-lg-4 col-md-6" >
                <div class="card">
                    <div class="card-body rounded" style="background-color: #EAFCE9">
                        <p style="font-size: 30px; ">Pilih Hari</p>
                        <form action="{{ route('daftarday') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="startDate" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="startDate" name="startDate" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+1 month')) }}">
                            </div>
                            <div class="mb-3">
                                <label for="endDate" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="endDate" name="endDate" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+2 month')) }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 offset-lg-2 ">
                <div style="font-size: 30px; ">Daftar Harga</div>
                <div class="card ">    
                        <div class="card-body rounded bg-success text-white">
                                <div class="row">
                                    <div class="col-8">
                                        <p style="font-size: 20px; font-weight:100">
                                            Senin - Jum'at  </p>
                                    </div>
                                    <div class="col-4">
                                        <p style="font-size: 20px; font-weight:100">
                                            Rp. 40.000/hari</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <p style="font-size: 20px; font-weight:100">
                                            Sabtu - Minggu  </p>
                                    </div>
                                    <div class="col-4">
                                        <p style="font-size: 20px; font-weight:100">
                                            Rp. 50.000/hari</p>
                                    </div>
                                </div>
                        </div>
                    </div>
            </div>
<div class="mt-3">
    <div class="card">
        <div class="card-header bg-success">
            <p class="card-title text-white" style="font-size: 30px">Ringkasan Pembayaran</p>
        </div>
        <div class="card-body">
            
        </div>
    </div>
</div>
</div>

@endsection