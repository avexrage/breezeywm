@extends('layouts.mainlayout')
@section('title', 'Daftar')
@section('content4')

<div class="container">
    @include('layouts.pesan')
    <h1 class="display-6">
    Daftar<br>
    Program </h1>
        <div class="row">
            <div class="col-lg-4 col-md-6" >
                <div class="card">
                    <div class="card-body rounded" style="background-color: #EAFCE9">
                        <p style="font-size: 30px; ">Pilih Hari</p>
                        <form action="{{ route('layouts.daftar') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startDate" name="startDate" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+1 month')) }}">
                            </div>
                            <div class="mb-3">
                                <label for="endDate" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="endDate" name="endDate" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+1 month')) }}">
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