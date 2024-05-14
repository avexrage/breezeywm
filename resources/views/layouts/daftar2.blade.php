@extends('layouts.mainlayout')
@section('title', 'Daftar')
@section('content5')

<div class="container">
    @include('layouts.pesan')
    <h1 class="display-6 text-success">
    Daftar Program <br>
    Grha Wredha Mulya</h1>
        <div class="row">
            <div class="col-lg-4 col-md-6" >
                <div class="card text-success">
                    <div class="card-body rounded" style="background-color: #EAFCE9">
                        <p style="font-size: 30px; ">Pilih Hari</p>
                        <form action="{{ route('daftargrha') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="startDate" class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="startDate" name="startDate" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+1 month')) }}">
                            </div>
                            <div class="mb-3">
                                <label for="tahun" class="form-label">Waktu Mengikuti Program</label>
                                <div class="d-flex align-items-center">
                                    <select class="form-control me-3" name="tahun" id="tahun" style="width: auto; ">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    <div>Tahun</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center ">
                                    <button class="btn btn-success text-white me-4">Tipe A</button>
                                    <button class="btn btn-success text-white">Tipe B</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 offset-lg-2 ">
                <div class="text-success" style="font-size: 30px; ">Daftar Harga</div>
                <div class="card ">    
                        <div class="card-body rounded bg-success text-white">
                                <div class="row">
                                    <div class="col-8">
                                        <p style="font-size: 20px; font-weight:100">
                                            Tipe A </p>
                                    </div>
                                    <div class="col-4">
                                        <p style="font-size: 20px; font-weight:100">
                                            Rp. 17.500.000/tahun</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <p style="font-size: 20px; font-weight:100">
                                            Tipe B </p>
                                    </div>
                                    <div class="col-4">
                                        <p style="font-size: 20px; font-weight:100">
                                            Rp. 20.000.000/tahun</p>
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
                    <div class="card-body" style="background-color: #EAFCE9">
                        <table class="table table-striped">
                              <tr>
                                <td scope="row">Tanggal Pendaftaran</th>
                                <td>: Mark</td>
                              </tr>
                              <tr>
                                <td scope="row">Tanggal Mulai Program</th>
                                <td>: Jacob</td>
                              </tr>
                              <tr>
                                <td scope="row">Tanggal Berakhir Program</th>
                                <td >: Larry the Bird</td>
                              </tr>
                              <tr>
                                <td scope="row">Lama Program</th>
                                <td >: Larry the Bird</td>
                              </tr>
                              <tr>
                                <td scope="row">Tipe Hunian</th>
                                <td >: Larry the Bird</td>
                              </tr>
                              <tr>
                                <td scope="row">Biaya</th>
                                <td >: Larry the Bird</td>
                              </tr>
                              <tr>
                                <td scope="row">Total Harga</th>
                                <td >: Larry the Bird</td>
                              </tr>
                          </table>
                    </div>
                </div>
            </div>
</div>

{{-- <div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Select Date Range</h5>
            <form>
                <div class="mb-3">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="startDate" name="startDate" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+1 month')) }}" onchange="updateSummary()">
                </div>
                <div class="mb-3">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="endDate" name="endDate" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+1 month')) }}" onchange="updateSummary()">
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-3" id="paymentSummary" style="display: none;">
        <div class="card-body">
            <h5 class="card-title">Payment Summary</h5>
            <p id="summaryText"></p>
            <div class="mb-3">
                <label for="paymentMethod" class="form-label">Choose Payment Method</label>
                <select class="form-control" id="paymentMethod">
                    <option value="Tunai">Tunai</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                </select>
            </div>
            <button type="button" class="btn btn-primary">Bayar</button>
        </div>
    </div>
</div>

<script>
    function updateSummary() {
        const startDate = new Date(document.getElementById('startDate').value);
        const endDate = new Date(document.getElementById('endDate').value);
        if (!isNaN(startDate.valueOf()) && !isNaN(endDate.valueOf()) && startDate <= endDate) {
            let totalCost = 0;
            let summary = "";
            for (let day = new Date(startDate); day <= endDate; day.setDate(day.getDate() + 1)) {
                const isWeekend = day.getDay() === 0 || day.getDay() === 6;
                const costPerDay = isWeekend ? 50000 : 40000;
                totalCost += costPerDay;
                summary += `${day.toDateString()} @ ${isWeekend ? 'Rp50,000' : 'Rp40,000'}<br>`;
            }
            summary += `<strong>Total = Rp${totalCost.toLocaleString()}</strong>`;
            document.getElementById('summaryText').innerHTML = summary;
            document.getElementById('paymentSummary').style.display = 'block';
        } else {
            document.getElementById('paymentSummary').style.display = 'none';
        }
    }
</script> --}}
@endsection