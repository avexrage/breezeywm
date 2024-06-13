@extends('layouts.mainlayout')
@section('title', 'Formulir Pendaftaran')
@section('content3')

<body class="bg-light">
    <div class="container text-success">
        <h1 class="display-6">
            Daftar Program <br>
            {{ $program->nama_program }}
        </h1>
    </div>
    <main class="container text-success">
        @include('layouts.pesan')

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Pilih Cara Pendaftaran</h5>
                <p class="card-text">Anda ingin menggunakan data peserta yang pernah didaftarkan atau mendaftar dengan data baru?</p>
                <button class="btn btn-secondary" onclick="showOldData()">Gunakan Data Lama</button>
                <button class="btn btn-success" onclick="showNewDataForm()">Daftar Baru</button>
            </div>
        </div>

        <div id="oldDataCards" style="display:none;">
            @forelse ($riwayatPendaftarans as $riwayatPendaftaran)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Data Riwayat Pendaftaran</h5>
                    <p class="card-text">
                        <strong>Nama:</strong> {{ $riwayatPendaftaran->nama_lengkap_peserta }}<br>
                        <strong>KTP:</strong> {{ $riwayatPendaftaran->ktp }}<br>
                        <strong>Alamat:</strong> {{ $riwayatPendaftaran->alamat }}<br>
                        <strong>Tempat Lahir:</strong> {{ $riwayatPendaftaran->tempat_lahir }}<br>
                        <strong>Tanggal Lahir:</strong> {{ $riwayatPendaftaran->tanggal_lahir }}<br>
                        <strong>Jenis Kelamin:</strong> {{ $riwayatPendaftaran->jenis_kelamin }}<br>
                        <strong>Agama:</strong> {{ $riwayatPendaftaran->agama }}<br>
                        <strong>Status Nikah:</strong> {{ $riwayatPendaftaran->statusnikah }}<br>
                        <strong>Pekerjaan:</strong> {{ $riwayatPendaftaran->pekerjaan }}<br>
                        <strong>Riwayat Penyakit:</strong> {{ $riwayatPendaftaran->riwayat_penyakit }}<br>
                        <strong>Asuransi:</strong> {{ $riwayatPendaftaran->nama_asuransi }}<br>
                        <strong>No Asuransi:</strong> {{ $riwayatPendaftaran->no_asuransi }}<br>
                        <strong>Hobi:</strong> {{ $riwayatPendaftaran->hobi }}<br>
                        <strong>Keahlian:</strong> {{ $riwayatPendaftaran->keahlian }}<br>
                        <strong>Bahasa:</strong> {{ $riwayatPendaftaran->bahasa }}<br>
                    </p>
                    <form action="{{ route('datalama', ['program_id' => $program->id_program, 'riwayat_id' => $riwayatPendaftaran->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Gunakan Data Ini</button>
                    </form>                
                </div>
            </div>
            @empty
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Data Riwayat Pendaftaran</h5>
                    <p class="card-text">Anda belum pernah melakukan pendaftaran.</p>
                </div>
            </div>
            @endforelse
        </div>

        <form action="{{ route('simpanform') }}" method="POST" id="newDataForm" style="display:none;">
            @csrf
            <input type="hidden" name="program_id" value="{{ $program->id_program }}">
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                <h3 class="mb-3">Isi Identitas Lansia</h3>
                <div class="mb-3 row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='nama' value="{{ Session::get('nama_lengkap_peserta') }}" id="nama" style="text-transform: capitalize;">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="ktp" class="col-sm-2 col-form-label">Nomor KTP</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='ktp' value="{{ Session::get('ktp') }}" id="ktp" style="text-transform: capitalize;">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat Lengkap</label>
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
                            <input class="form-check-input" type="radio" name="kelamin" value="Laki-laki" {{ Session::get('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }} id="kelaminLaki">
                            <label class="form-check-label" for="kelaminLaki">Laki-laki</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kelamin" value="Perempuan" {{ Session::get('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }} id="kelaminPerempuan">
                            <label class="form-check-label" for="kelaminPerempuan">Perempuan</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="agama" class="col-sm-2 col-form-label">Agama</label>
                    <div class="col-sm-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="agama" id="agamaIslam" value="Islam" {{ Session::get('agama') == 'Islam' ? 'checked' : '' }}>
                            <label class="form-check-label" for="agamaIslam">Islam</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="agama" id="agamaKristen" value="Kristen" {{ Session::get('agama') == 'Kristen' ? 'checked' : '' }}>
                            <label class="form-check-label" for="agamaKristen">Kristen</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="agama" id="agamaKatolik" value="Katolik" {{ Session::get('agama') == 'Katolik' ? 'checked' : '' }}>
                            <label class="form-check-label" for="agamaKatolik">Katolik</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="agama" id="agamaHindu" value="Hindu" {{ Session::get('agama') == 'Hindu' ? 'checked' : '' }}>
                            <label class="form-check-label" for="agamaHindu">Hindu</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="agama" id="agamaBudha" value="Buddha" {{ Session::get('agama') == 'Buddha' ? 'checked' : '' }}>
                            <label class="form-check-label" for="agamaBudha">Buddha</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="agama" id="agamaKhonghucu" value="Khonghucu" {{ Session::get('agama') == 'Khonghucu' ? 'checked' : '' }}>
                            <label class="form-check-label" for="agamaKhonghucu">Khonghucu</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="statusNikah" class="col-sm-2 col-form-label">Status Nikah</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="statusNikah" id="statusNikah" style="width: auto; min-width: 100px;">
                            <option value="" disabled {{ Session::has('statusnikah') ? '' : 'selected' }}>Pilih Opsi</option>
                            <option value="Kawin" {{ Session::get('statusnikah') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                            <option value="Belum Kawin" {{ Session::get('statusnikah') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                            <option value="Cerai Hidup" {{ Session::get('statusnikah') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                            <option value="Cerai Mati" {{ Session::get('statusnikah') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
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
                    <label for="penyakit" class="col-sm-2 col-form-label">Riwayat Penyakit</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='penyakit' value="{{ Session::get('riwayat_penyakit') }}" id="penyakit" style="text-transform: capitalize;">
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
                        <input type="text" class="form-control" name='noasuransi' value="{{ Session::get('no_asuransi') }}" id="noasuransi">
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
                    <div class="col-sm-10 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success" name="submit">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <script>
        function showNewDataForm() {
            document.getElementById('newDataForm').style.display = 'block';
            document.getElementById('oldDataCards').style.display = 'none';
        }

        function showOldData() {
            document.getElementById('oldDataCards').style.display = 'block';
            document.getElementById('newDataForm').style.display = 'none';
        }
    </script>
</body>

@endsection
