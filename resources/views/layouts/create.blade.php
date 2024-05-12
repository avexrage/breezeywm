@extends('layouts.mainlayout')
@section('title', 'Formulir Pendaftaran')
@section('content3')

<body class="bg-light" >
<div class="container text-success">
    <h1 class="display-6">Daftar Program </h1>
    <h1 class="display-6"> {{ $program->nama_program }}</h1>
</div>
<main class="container text-success">
<!-- START FORM -->
@include('layouts.pesan')
<form action="{{ route('layouts.store') }}" method="POST">
@csrf
<input type="hidden" name="program_id" value="{{ $program->id_program }}">
<div class="my-3 p-3 bg-body rounded shadow-sm">
    <div class="mb-3 row">
        <label class="col-sm-2 col-form-label">ISI IDENTITAS LANSIA</label>
    </div>
    <div class="mb-3 row">
        <label for="nama" class="col-sm-2 col-form-label">Nama Lengkap</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name='nama' value="{{ Session::get ('nama_lengkap_peserta') }}" id="nama" style="text-transform: capitalize;">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="ktp" class="col-sm-2 col-form-label">Nomor KTP</label>
        <div class="col-sm-10">
            <input type="string" class="form-control" name='ktp' value="{{ Session::get('ktp') }}" id="ktp" style="text-transform: capitalize;">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name='alamat' value="{{ Session::get('alamat') }}" id="alamat" style="text-transform: capitalize;">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="tlahir" class="col-sm-2 col-form-label">Tempat Lahir</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name='tlahir' value="{{ Session::get('tempat_lahir') }}" id="tlahir" style="text-transform: capitalize;">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="tgllhr" class="col-sm-2 col-form-label">Tanggal Lahir</label>
        <div class="col-sm-10">
            <input type="date" class="form-control" name='tgllhr' value="{{ Session::get('tanggal_lahir') }}" id="tgllhr">
        </div>
    </div>
    <div class="mb-3 row">
    <label for="jenisKelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
    <div class="col-sm-10">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="kelamin" value="Laki-laki" {{ Session::get('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }} id="kelaminLaki" value="Laki-laki">
            <label class="form-check-label" for="kelaminLaki">
                Laki-laki
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="kelamin" value="Perempuan" {{ Session::get('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }} id="kelaminPerempuan" value="Perempuan">
            <label class="form-check-label" for="kelaminPerempuan">
                Perempuan
            </label>
        </div>
    </div>
    </div>
    <div class="mb-3 row">
    <label for="agama" class="col-sm-2 col-form-label">Agama</label>
    <div class="col-sm-10">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="agama" id="agamaIslam" value="Islam" {{ Session::get('agama') == 'Islam' ? 'checked' : '' }}>
            <label class="form-check-label" for="agamaIslam">
                Islam
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="agama" id="agamaKristen" value="Kristen" {{ Session::get('agama') == 'Kristen' ? 'checked' : '' }}>
            <label class="form-check-label" for="agamaKristen">
                Kristen
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="agama" id="agamaKatolik" value="Katolik" {{ Session::get('agama') == 'Katolik' ? 'checked' : '' }}>
            <label class="form-check-label" for="agamaKatolik">
                Katolik
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="agama" id="agamaHindu" value="Hindu" {{ Session::get('agama') == 'Hindu' ? 'checked' : '' }}>
            <label class="form-check-label" for="agamaHindu">
                Hindu
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="agama" id="agamaBudha" value="Buddha" {{ Session::get('agama') == 'Buddha' ? 'checked' : '' }}>
            <label class="form-check-label" for="agamaBudha">
                Budha
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="agama" id="agamaKhonghucu" value="Khonghucu" {{ Session::get('agama') == 'Khonghucu' ? 'checked' : '' }}>
            <label class="form-check-label" for="agamaKhonghucu">
                Khonghucu
            </label>
        </div>
    </div>
    </div>
    <div class="mb-3 row">
        <label for="statusNikah" class="col-sm-2 col-form-label">Status Nikah</label>
        <div class="col-sm-10">
            <select class="form-control" name="statusNikah" id="statusNikah" style="width: auto; min-width: 100px;">
                <option value="" disabled {{ Session::has('status') ? '' : 'selected' }}>Pilih Opsi</option>
                <option value="Kawin" {{ Session::get('status') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                <option value="Belum Kawin" {{ Session::get('status') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                <option value="Cerai Hidup" {{ Session::get('status') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                <option value="Cerai Mati" {{ Session::get('status') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
            </select>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="pekerjaan" class="col-sm-2 col-form-label">Pekerjaan</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name='pekerjaan' value="{{ Session::get('pekerjaan') }}" id="pekerjaan" style="text-transform: capitalize;">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="asuransi" class="col-sm-2 col-form-label">Nama Asuransi Kesehatan</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name='asuransi' value="{{ Session::get('nama_asuransi') }}" id="asuransi" style="text-transform: capitalize;">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="noasuransi" class="col-sm-2 col-form-label">Nomor Asuransi </label>
        <div class="col-sm-10">
            <input type="teks" class="form-control" name='noasuransi' value="{{ Session::get('no_asuransi') }}" id="noasuransi">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="hobi" class="col-sm-2 col-form-label">Hobi</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name='hobi' value="{{ Session::get('hobi') }}" id="hobi" style="text-transform: capitalize;">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="keahlian" class="col-sm-2 col-form-label">Keahlian</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name='keahlian' value="{{ Session::get('keahlian') }}" id="keahlian" style="text-transform: capitalize;">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="bahasa" class="col-sm-2 col-form-label">Bahasa Sehari - hari</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name='bahasa' value="{{ Session::get('bahasa') }}" id="bahasa" style="text-transform: capitalize;">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="submit" class="col-sm-2 col-form-label"></label>
        <div class="col-sm-10 d-flex justify-content-end"><button type="submit" class="btn btn-success" name="submit">SIMPAN</button></div>
</div>
</form>
</div>
<!-- AKHIR FORM -->
</main>
@endsection