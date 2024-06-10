@extends('admin.mainlayout')

@section('title', 'Cetak Pendaftaran Day Care')

@section('breadcrumb')
<ol class="breadcrumb float-sm-left">
    <li class="breadcrumb-item">
        <a href="{{ route('admin') }}" class="text-decoration-none active">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('datapdftrday') }}" class="text-decoration-none active">Data Pendaftaran</a>
    </li>
    <li class="breadcrumb-item">
        Cetak Day Care
    </li>
</ol>
@endsection

@section('content')
<div class="card col-4 rounded shadow text-white align-items-center mb-2" style="background: #0D592C; border:none">
    <h1 class="display-6">Cetak Data Pendaftaran</h1>      
</div>
@include('layouts.pesan')
<div class="card mb-4 shadow" style="border:none">
    <div class="card-body">
        <form method="GET" action="{{ route('cetakpdftrday') }}">
            <div class="row mb-3">
                <div class="col-lg-2">
                    Tanggal Awal Pendaftaran
                </div>
                <div class="col-lg-10">
                    <input type="date" name="start_date" class="form-control" placeholder="Tanggal Mulai">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-2">
                    Tanggal Akhir Pendaftaran
                </div>
                <div class="col-lg-10">
                    <input type="date" name="end_date" class="form-control" placeholder="Tanggal Selesai">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col ">
                    <button type="submit" class="btn btn-primary w-100">Cetak Data Pendaftaran</button>
                </div>
            </div>  
        </form>
    </div>
</div>
@endsection
