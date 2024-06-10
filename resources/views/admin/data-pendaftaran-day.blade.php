@extends('admin.mainlayout')

@section('title', 'Data Pendaftaran Day Care')

@section('breadcrumb')
<ol class="breadcrumb float-sm-left">
    <li class="breadcrumb-item">
        <a href="{{ route('admin') }}" class="text-decoration-none active">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        Data Pendaftaran
    </li>
    <li class="breadcrumb-item">
        Day Care
    </li>
</ol>
@endsection

@section('content')

<div class="card col-2 rounded shadow text-white align-items-center mb-2 " style="Background: #0D592C; border: none">
    <h1 class="display-6">Day Care</h1>      
</div>
@include('layouts.pesan')
<div class="card mb-4 shadow" style="border: none">
    <div class="card-body">
        {{-- Search --}}
        <div class="d-flex justify-content-between align-items-center mb-2">
            <form class="d-inline-block" method="GET" action="{{ route('datapdftrday') }}">
                <div class="input-group" style="width: 300px;">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama peserta" value="{{ request()->get('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    @if(request()->has('search') && request()->get('search') != '')
                        <a href="{{ route('datapdftrday') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
            <a href="{{ route('showcetakpdftrday') }}" class="btn btn-sm btn-primary ml-2">
                <i class="bi bi-printer"></i> Cetak Data
            </a>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead class="custom-thead">
                    <tr>
                        <th>Nama Peserta</th>
                        <th>Nama Asuransi</th>
                        <th>Nomor Asuransi</th>
                        <th>Tanggal Daftar</th>
                        <th>Status Pendaftaran</th>
                        <th>Tanggal</th>
                        <th>Harga</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendaftaranDay as $data)
                        <tr>
                            <td class="align-middle" rowspan="{{ $data['program_details']->count() }}">{{ $data['nama_lengkap_peserta'] }}</td>
                            <td class="align-middle" rowspan="{{ $data['program_details']->count() }}">{{ $data['nama_asuransi'] }}</td>
                            <td class="align-middle" rowspan="{{ $data['program_details']->count() }}">{{ $data['no_asuransi'] }}</td>
                            <td class="align-middle" rowspan="{{ $data['program_details']->count() }}">{{ \Carbon\Carbon::parse($data['tanggal_daftar'])->format('d/m/Y') }}</td>
                            <td class="align-middle" rowspan="{{ $data['program_details']->count() }}">
                                @if($data['status_pendaftaran'] == 'Diterima')
                                    <span class="badge bg-success">{{ $data['status_pendaftaran'] }}</span>
                                @else
                                    <span class="badge bg-primary">{{ $data['status_pendaftaran'] }}</span>
                                @endif
                            </td>
                            @foreach($data['program_details'] as $key => $detail)
                                @if ($key > 0)
                                    <tr>
                                @endif
                                <td>{{ \Carbon\Carbon::parse($detail['tanggal'])->format('d/m/Y') }}</td>
                                <td>{{ $detail['harga'] }}</td>
                                <td>{{ $detail['waktu'] }}</td>
                                @if ($key == 0)
                                    <td class="align-middle" rowspan="{{ $data['program_details']->count() }}">
                                        <a href="#" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal" onclick="showDetail({{ json_encode($data) }})">
                                            <i class="bi bi-info-circle text-white"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" onclick="showEditModal({{ json_encode($data) }})">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </td>
                                @endif
                                </tr>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination Links and Info Text -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Showing {{ $pendaftaranDay->firstItem() }} to {{ $pendaftaranDay->lastItem() }} of {{ $pendaftaranDay->total() }} entries
            </div>
            <div>
                {{ $pendaftaranDay->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>


<!-- Detail Pendaftaran Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border:none">
            <div class="modal-header text-white" style="background: #0D592C;">
                <h5 class="modal-title" id="detailModalLabel">Detail Pendaftaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Informasi Pendaftaran:</h5>
                <table class="table ">
                    <tbody>
                        <tr>
                            <td>ID Pendaftaran</td>
                            <td id="pendaftaranId"></td>
                        </tr>
                        <tr>
                            <td>Nama Peserta</td>
                            <td id="namaPeserta"></td>
                        </tr>
                        <tr>
                            <td>Nama Program</td>
                            <td id="namaProgram"></td>
                        </tr>
                        <tr>
                            <td>Tanggal Pendaftaran</td>
                            <td id="tanggalPendaftaran"></td>
                        </tr>
                        <tr>
                            <td>Status Pendaftaran</td>
                            <td id="statusPendaftaran"></td>
                        </tr>
                        <tr>
                            <td><h5>Informasi Peserta:</h5></td>
                        </tr>
                        <tr>
                            <td>Nomor KTP</td>
                            <td id="nomorKtpPeserta"></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td id="alamatPeserta"></td>
                        </tr>
                        <tr>
                            <td>Tempat Lahir</td>
                            <td id="tempatLahirPeserta"></td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td id="tanggalLahirPeserta"></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td id="jenisKelaminPeserta"></td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td id="agamaPeserta"></td>
                        </tr>
                        <tr>
                            <td>Status Nikah</td>
                            <td id="statusNikahPeserta"></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td id="pekerjaanPeserta"></td>
                        </tr>
                        <tr>
                            <td>Keahlian</td>
                            <td id="keahlianPeserta"></td>
                        </tr>
                        <tr>
                            <td>Hobi</td>
                            <td id="hobiPeserta"></td>
                        </tr>
                        <tr>
                            <td>Bahasa</td>
                            <td id="bahasaPeserta">jawa</td>
                        </tr>
                        <tr>
                            <td>Riwayat Penyakit</td>
                            <td id="riwayatPenyakitPeserta"></td>
                        </tr>
                        <tr>
                            <td><h5>Informasi Penanggung Jawab:</h5></td>
                        </tr>
                        <tr>
                            <td>Nomor KTP Penanggung Jawab</td>
                            <td id="nomorKtpPenanggungJawab"></td>
                        </tr>
                        <tr>
                            <td>Nama Penanggung Jawab</td>
                            <td id="namaPenanggungJawab"></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td id="emailPenanggungJawab"></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td id="alamatPenanggungJawab"></td>
                        </tr>
                        <tr>
                            <td>Nomor HP</td>
                            <td id="nomorHpPenanggungJawab"></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td id="pekerjaanPenanggungJawab"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Edit Pendaftaran Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: #0D592C">
                <h5 class="modal-title text-white" id="editModalLabel">Edit Data Pendaftaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST" action="{{ route('updatepdftrday') }}">
                    @csrf
                    <input type="hidden" name="pendaftaran_id" id="editPendaftaranId">
                    <div class="mb-3">
                        <label for="statusPendaftaran" class="form-label">Status Pendaftaran</label>
                        <select class="form-control" id="statusPendaftaran" name="status_pendaftaran">
                            <option disabled selected>Pilih Status Pendaftaran</option>
                            <option value="Baru">Baru</option>
                            <option value="Diterima">Diterima</option>
                            {{-- <option value="Ditolak">Ditolak</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                            <option value="Menunggu Jadwal">Menunggu Jadwal</option> --}}
                        </select>
                    </div>
                    {{-- <div class="mb-3">
                        <label for="tanggalMulai" class="form-label">Masukkan Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggalMulai" name="tanggal_mulai">
                    </div>
                    <div class="mb-3">
                        <label for="tanggalSelesai" class="form-label">Masukkan Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tanggalSelesai" name="tanggal_selesai">
                    </div> --}}
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showDetail(data) {
        document.getElementById('pendaftaranId').innerText =': ' + data.pendaftaran_id;
        document.getElementById('namaPeserta').innerText = ': ' + data.nama_lengkap_peserta;
        document.getElementById('namaProgram').innerText = ': ' + data.program;
        document.getElementById('tanggalPendaftaran').innerText = ': ' + new Date(data.tanggal_daftar).toLocaleDateString();
        document.getElementById('statusPendaftaran').innerText = ': ' + data.status_pendaftaran;
        
        document.getElementById('nomorKtpPeserta').innerText = ': ' + data.nomor_ktp_peserta;
        document.getElementById('alamatPeserta').innerText = ': ' + data.alamat_peserta;
        document.getElementById('tempatLahirPeserta').innerText = ': ' + data.tempat_lahir_peserta;
        document.getElementById('tanggalLahirPeserta').innerText = ': ' + new Date(data.tanggal_lahir_peserta).toLocaleDateString();
        document.getElementById('jenisKelaminPeserta').innerText = ': ' + data.jenis_kelamin_peserta;
        document.getElementById('agamaPeserta').innerText = ': ' + data.agama_peserta;
        document.getElementById('statusNikahPeserta').innerText = ': ' + data.status_nikah_peserta;
        document.getElementById('pekerjaanPeserta').innerText = ': ' + data.pekerjaan_peserta;
        document.getElementById('keahlianPeserta').innerText = ': ' + data.keahlian_peserta;
        document.getElementById('hobiPeserta').innerText = ': ' + data.hobi_peserta;
        document.getElementById('bahasaPeserta').innerText = ': ' + data.bahasa_peserta;
        document.getElementById('riwayatPenyakitPeserta').innerText = ': ' + data.riwayat_penyakit_peserta;
        
        document.getElementById('nomorKtpPenanggungJawab').innerText = ': ' + data.nomor_ktp_penanggung_jawab;
        document.getElementById('namaPenanggungJawab').innerText = ': ' + data.nama_penanggung_jawab;
        document.getElementById('emailPenanggungJawab').innerText = ': ' + data.email_penanggung_jawab;
        document.getElementById('alamatPenanggungJawab').innerText = ': ' + data.alamat_penanggung_jawab;
        document.getElementById('nomorHpPenanggungJawab').innerText = ': ' + data.nomor_hp_penanggung_jawab;
        document.getElementById('pekerjaanPenanggungJawab').innerText = ': ' + data.pekerjaan_penanggung_jawab;
    }

    function showEditModal(data) {
        document.getElementById('editPendaftaranId').value = data.pendaftaran_id;
        document.getElementById('statusPendaftaran').value = data.status_pendaftaran;
        document.getElementById('tanggalMulai').value = data.tanggal_mulai ? new Date(data.tanggal_mulai).toISOString().split('T')[0] : '';
        document.getElementById('tanggalSelesai').value = data.tanggal_selesai ? new Date(data.tanggal_selesai).toISOString().split('T')[0] : '';
    }
</script>

@endsection