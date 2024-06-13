@extends('layouts.mainlayout')
@section('title', 'Pilihan Program')
@section('content2')
@include('layouts.pesan')

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-6 mb-3 mb-sm-0">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Day Care</h5>
          <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dignissimos sunt illum, ad deleniti maxime pariatur tempore ipsa rem incidunt perferendis, exercitationem nobis voluptates itaque similique, eum animi delectus minima. Eius?</p>
          <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmationModal" data-id="111">Daftar Sekarang</button>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Grha Wredha Mulya</h5>
          <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis consequuntur, similique quibusdam cum possimus odio repudiandae illo sapiente saepe officiis, accusamus perferendis magnam sequi eligendi enim vitae pariatur corporis non?</p>
          <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmationModal" data-id="21">Daftar Sekarang</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Pendaftaran</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              Apakah lansia yang akan anda daftarkan berusia minimal 60 tahun, masih mandiri, dan tidak sedang bed rest?
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="button" class="btn btn-success" id="modalConfirmButton">Ya, Daftarkan</button>
          </div>
      </div>
  </div>
</div>

{{-- <section class="asuransi-section mb-5" id="asuransi">
    <div class="head-container">
        <div class="title text-center mb-5">Kami Menerima Segala Jenis Asuransi</div>
    </div>
    <div class="container">
        <div class="row">
            <!-- Gambar 1-4 -->
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 p-2">
                <img src="{{ asset('images/a-bpjs.png') }}" class="img-fluid img-border " alt="asuransi 1">
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 p-2">
                <img src="{{ asset('images/a-jasin.jpg') }}" class="img-fluid img-border" alt="asuransi 2">
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 p-2">
                <img src="{{ asset('images/a-jmas.png') }}" class="img-fluid img-border" alt="asuransi 3">
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 p-2">
                <img src="{{ asset('images/a-jwsr.png') }}" class="img-fluid img-border" alt="asuransi 4">
            </div>
            <!-- Gambar 5-8 -->
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 p-2">
                <img src="{{ asset('images/a-prud.png') }}" class="img-fluid" alt="asuransi 5">
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 p-2">
                <img src="{{ asset('images/a-simas.png') }}" class="img-fluid" alt="asuransi 6">
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 p-2">
                <img src="{{ asset('images/a-videi.png') }}" class="img-fluid" alt="asuransi 7">
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 p-2">
                <img src="{{ asset('images/a-astra.png') }}" class="img-fluid" alt="asuransi 8">
            </div>
        </div>
    </div>
</section> --}}
<script>
document.addEventListener("DOMContentLoaded", function() {
    var confirmButtons = document.querySelectorAll('[data-bs-target="#confirmationModal"]');
    confirmButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var programId = this.getAttribute('data-id');
            var modalConfirmButton = document.getElementById('modalConfirmButton');
            console.log("Button clicked, programId:", programId);
            modalConfirmButton.setAttribute('data-id', programId);
        });
    });

    var modalConfirmButton = document.getElementById('modalConfirmButton');
    modalConfirmButton.addEventListener('click', function() {
        var programId = this.getAttribute('data-id');
        console.log("Modal confirm button clicked, redirecting to:", "{{ route('tampilform') }}" + "?id=" + programId);
        window.location.href = "{{ route('tampilform') }}" + "?id=" + programId;
    });
});
</script>
@endsection