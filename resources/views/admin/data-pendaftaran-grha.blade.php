@extends('admin.mainlayout')

@section('title', 'Data Pendaftaran Grha Wredha Mulya')

@section('breadcrumb')
<ol class="breadcrumb float-sm-left">
    <li class="breadcrumb-item">
        <a href="{{ route('admin') }}" class="text-decoration-none active">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        Data Pendaftaran
    </li>
    <li class="breadcrumb-item">
        Grha Wredha Mulya
    </li>
</ol>
@endsection

@section('content')
<div class="card col-3 rounded shadow text-white align-items-center mb-2 " style="Background: #0D592C; border: none">
    <h1 class="display-6">Grha Wredha Mulya</h1>      
</div>
@include('layouts.pesan')
<div class="card mb-4 shadow" style="border: none">
    <div class="card-body">
        {{-- Search --}}
        <div class="d-flex justify-content-between align-items-center mb-2">
            <form class="d-inline-block" method="GET" action="{{ route('datapdftrgrha') }}">
                <div class="input-group" style="width: 300px;">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama peserta" value="{{ request()->get('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    @if(request()->has('search') && request()->get('search') != '')
                        <a href="{{ route('datapdftrgrha') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
            <a href="{{ route('showcetakpdftrgrha') }}" class="btn btn-sm btn-primary ml-2">
                <i class="bi bi-printer"></i> Cetak Data
            </a>
        </div>
        {{-- Tabel  --}}
        <div class="table-responsive">
            <table class="table">
                <thead class="custom-thead">
                    <tr>
                        <th>Nama Peserta</th>
                        <th>Nama Asuransi</th>
                        <th>Nomor Asuransi</th>
                        <th>Tanggal Daftar</th>
                        <th>Status Pendaftaran</th>
                        <th>Durasi</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Keluar</th>
                        <th>Wisma</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendaftaranGrha as $data)
                        <tr>
                            <td>{{ $data->nama_lengkap_peserta }}</td>
                            <td>{{ $data->nama_asuransi }}</td>
                            <td>{{ $data->no_asuransi }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->tanggal_daftar)->format('d/m/Y') }}</td>
                            <td>
                                @if($data->status_pendaftaran == 'Diterima')
                                    <span class="badge bg-success">{{ $data->status_pendaftaran }}</span>
                                @elseif($data->status_pendaftaran == 'Menunggu Jadwal')
                                    <span class="badge bg-warning">{{ $data->status_pendaftaran }}</span>
                                @elseif($data->status_pendaftaran == 'Ditolak' || $data->status_pendaftaran == 'Dibatalkan')
                                    <span class="badge bg-danger">{{ $data->status_pendaftaran }}</span>
                                @else
                                    <span class="badge bg-primary">{{ $data->status_pendaftaran }}</span>
                                @endif
                            </td>
                            <td>{{ $data->durasi }} tahun</td>
                            <td>{{ $data->check_in ? \Carbon\Carbon::parse($data->check_in )->format('d/m/Y') : '-' }}</td>
                            <td>{{ $data->check_out ? \Carbon\Carbon::parse($data->check_out )->format('d/m/Y') : '-' }}</td>
                            <td>{{ $data->wisma }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal" onclick="showDetail({{ json_encode($data) }})">
                                    <i class="bi bi-info-circle text-white"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" onclick="showEditModal({{ json_encode($data) }})">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination Links and Info Text -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Showing {{ $pendaftaranGrha->firstItem() }} to {{ $pendaftaranGrha->lastItem() }} of {{ $pendaftaranGrha->total() }} entries
            </div>
            <div>
                {{ $pendaftaranGrha->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- Detail Pendaftaran Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border:none">
            <div class="modal-header" style="background: #0D592C">
                <h5 class="modal-title text-white" id="detailModalLabel">Detail Pendaftaran</h5>
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
                            <td>Alasan</td>
                            <td id="alasaN"></td>
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
                <form id="editForm" method="POST" action="{{ route('updatepdftrgrha') }}">
                    @csrf
                    <input type="hidden" name="pendaftaran_id" id="editPendaftaranId">
                    <div class="mb-3">
                        <label for="statusPendaftaran" class="form-label">Status Pendaftaran</label>
                        <select class="form-control" id="statusPendaftaran" name="status_pendaftaran">
                            <option disabled selected>Pilih Status Pendaftaran</option>
                            <option value="Baru">Baru</option>
                            <option value="Diterima">Diterima</option>
                            <option value="Ditolak">Ditolak</option>
                            <option value="Dibatalkan">Dibatalkan</option>
                            <option value="Menunggu Jadwal">Menunggu Jadwal</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alasan" class="form-label">Alasan</label>
                        <textarea class="form-control" id="alasan" name="alasan"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tanggalMulai" class="form-label">Masukkan Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggalMulai" name="tanggal_mulai">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="clearTanggalMulai" name="clear_tanggal_mulai">
                            <label class="form-check-label" for="clearTanggalMulai">
                                Kosongkan Tanggal Mulai
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="tanggalSelesai" class="form-label">Masukkan Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tanggalSelesai" name="tanggal_selesai">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="clearTanggalSelesai" name="clear_tanggal_selesai">
                            <label class="form-check-label" for="clearTanggalSelesai">
                                Kosongkan Tanggal Selesai
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function showDetail(data) {
        document.getElementById('pendaftaranId').innerText = data.pendaftaran_id;
        document.getElementById('namaPeserta').innerText = data.nama_lengkap_peserta;
        document.getElementById('namaProgram').innerText = data.program;
        document.getElementById('tanggalPendaftaran').innerText = new Date(data.tanggal_daftar).toLocaleDateString();
        document.getElementById('statusPendaftaran').innerText = data.status_pendaftaran;
        document.getElementById('alasaN').innerText = data.alasan;

        document.getElementById('nomorKtpPeserta').innerText = data.nomor_ktp_peserta;
        document.getElementById('alamatPeserta').innerText = data.alamat_peserta;
        document.getElementById('tempatLahirPeserta').innerText = data.tempat_lahir_peserta;
        document.getElementById('tanggalLahirPeserta').innerText = new Date(data.tanggal_lahir_peserta).toLocaleDateString();
        document.getElementById('jenisKelaminPeserta').innerText = data.jenis_kelamin_peserta;
        document.getElementById('agamaPeserta').innerText = data.agama_peserta;
        document.getElementById('statusNikahPeserta').innerText = data.status_nikah_peserta;
        document.getElementById('pekerjaanPeserta').innerText = data.pekerjaan_peserta;
        document.getElementById('keahlianPeserta').innerText = data.keahlian_peserta;
        document.getElementById('hobiPeserta').innerText = data.hobi_peserta;
        document.getElementById('bahasaPeserta').innerText = data.bahasa_peserta;
        document.getElementById('riwayatPenyakitPeserta').innerText = data.riwayat_penyakit_peserta;

        document.getElementById('nomorKtpPenanggungJawab').innerText = data.nomor_ktp_penanggung_jawab;
        document.getElementById('namaPenanggungJawab').innerText = data.nama_penanggung_jawab;
        document.getElementById('emailPenanggungJawab').innerText = data.email_penanggung_jawab;
        document.getElementById('alamatPenanggungJawab').innerText = data.alamat_penanggung_jawab;
        document.getElementById('nomorHpPenanggungJawab').innerText = data.nomor_hp_penanggung_jawab;
        document.getElementById('pekerjaanPenanggungJawab').innerText = data.pekerjaan_penanggung_jawab;
    }

    function showEditModal(data) {
        document.getElementById('editPendaftaranId').value = data.pendaftaran_id;
        document.getElementById('statusPendaftaran').value = data.status_pendaftaran;
        document.getElementById('tanggalMulai').value = data.tanggal_masuk ? new Date(data.tanggal_masuk).toISOString().split('T')[0] : '';
        document.getElementById('tanggalSelesai').value = data.tanggal_keluar ? new Date(data.tanggal_keluar).toISOString().split('T')[0] : '';
    }

</script>

@endsection
