@extends('layouts.mainlayout')
@section('title', 'Daftar')
@section('content4')

<div class="container text-success">
    @include('layouts.pesan')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="display-6">Daftar Program<br>Day Care</h1>
        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#cancelModal">
            <i class="bi bi-arrow-left"></i>
        </button>
    </div>
    <div class="row">
        <!-- Pilih Hari Section -->
        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body rounded text-success">
                    <p style="font-size: 30px;">Pilih Hari</p>
                    <form name="myForm" id="form2" action="{{ route('daftarday') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="startDate" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="startDate" name="startDate" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+1 month')) }}">
                        </div>
                        <div class="mb-3">
                            <label for="endDate" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="endDate" name="endDate" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+2 month')) }}">
                        </div>
                        <input type="hidden" id="totalPrice" name="totalPrice" value="">
                        <div class="mb-3">
                            <label for="metodePembayaran" class="form-label">Metode Pembayaran</label>
                            <select class="form-control" id="metodePembayaran" name="metodePembayaran">
                                <option value="" disabled selected>Pilih Pembayaran</option>
                                <option value="Tunai">Tunai</option>
                                <option value="Transfer BRI">Transfer BRI</option>
                            </select>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-sm-10 offset-sm-2 d-flex justify-content-end">
                                <button type="submit" class="btn btn-success" name="submit">DAFTAR</button>
                            </div>
                            {{-- data-bs-toggle="modal" data-bs-target="#confirmModal"  --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Daftar Harga Section -->
        <div class="col-lg-6 offset-lg-2">
            <div style="font-size: 30px;">Daftar Harga</div>
            <div class="card">
                <div class="card-body rounded bg-success text-white">
                    <div class="row">
                        <div class="col-8">
                            <p style="font-size: 20px; font-weight: 100;">Senin - Jum'at</p>
                        </div>
                        <div class="col-4">
                            <p style="font-size: 20px; font-weight: 100;">Rp. 40.000/hari</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <p style="font-size: 20px; font-weight: 100;">Sabtu - Minggu</p>
                        </div>
                        <div class="col-4">
                            <p style="font-size: 20px; font-weight: 100;">Rp. 50.000/hari</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Pembayaran Section -->
    <div id="summary" class="my-3">
        <div class="card">
            <div class="card-header bg-success">
                <p class="card-title text-white" style="font-size: 30px;">Ringkasan Pembayaran</p>
            </div>
            <div class="card-body rounded">
                <table class="table">
                    <tr>
                        <td scope="row" class="text-success">Tanggal Mulai Program</td>
                        <td id="summaryStartDate"></td>
                    </tr>
                    <tr>
                        <td scope="row" class="text-success">Tanggal Berakhir Program</td>
                        <td id="summaryEndDate"></td>
                    </tr>
                    <tr>
                        <td scope="row" class="text-success">Lama Program</td>
                        <td id="summaryDuration"></td>
                    </tr>
                    <tr>
                        <td scope="row" class="text-success">Biaya</td>
                        <td>
                            <ul id="summaryCostDetails"></ul>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" class="text-success">Metode Pembayaran</td>
                        <td id="paymentMethod"></td>
                    </tr>
                    <tr>
                        <td scope="row" class="text-success"><strong>Total Harga</strong></td>
                        <td id="summaryTotalPrice"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
   <!-- Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Batalkan Pendaftaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Anda yakin mau membatalkan pendaftaran? Data yang sudah disimpan akan hilang.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('cancel') }}" class="btn btn-danger">Yes, Cancel</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Pendaftaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Data pendaftaran program sudah benar? Silahkan cek kembali data anda.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="submitForm()">Yes, Confirm</button>
            </div>
        </div>
    </div>
</div>


 <script>
    document.addEventListener('DOMContentLoaded', function () {
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    const paymentMethodSelect = document.getElementById('metodePembayaran');
    const summaryStartDate = document.getElementById('summaryStartDate');
    const summaryEndDate = document.getElementById('summaryEndDate');
    const summaryDuration = document.getElementById('summaryDuration');
    const summaryTotalPrice = document.getElementById('summaryTotalPrice');
    const summaryCostDetails = document.getElementById('summaryCostDetails');
    const paymentMethodDisplay = document.getElementById('paymentMethod');
    const totalPriceInput = document.getElementById('totalPrice');

    function updateSummary() {
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);

        if (startDate && endDate && startDate <= endDate) {
            summaryStartDate.textContent = `: ${startDate.toLocaleDateString('id-ID')}`;
            summaryEndDate.textContent = `: ${endDate.toLocaleDateString('id-ID')}`;

            const timeDiff = endDate - startDate;
            const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;
            summaryDuration.textContent = `: ${daysDiff} hari`;

            let totalPrice = 0;
            summaryCostDetails.innerHTML = '';
            for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
                const dayOfWeek = d.getDay();
                const dayNames = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
                const dayString = d.toLocaleDateString('id-ID');
                let cost = (dayOfWeek === 0 || dayOfWeek === 6) ? 50000 : 40000;
                summaryCostDetails.innerHTML += `<li>${dayString} (${dayNames[dayOfWeek]}): Rp. ${cost.toLocaleString('id-ID')}</li>`;
                totalPrice += cost;
            }
            summaryTotalPrice.textContent = `: Rp. ${totalPrice.toLocaleString('id-ID')}`;
            totalPriceInput.value = totalPrice; // Set total price in hidden input
        } else {
            summaryStartDate.textContent = ': -';
            summaryEndDate.textContent = ': -';
            summaryDuration.textContent = ': -';
            summaryTotalPrice.textContent = ': -';
            summaryCostDetails.innerHTML = '';
            totalPriceInput.value = ''; // Clear total price in hidden input
            paymentMethodDisplay.textContent = ': -';
        }

        // Memperbarui tampilan metode pembayaran
        if (paymentMethodSelect.value) {
            const paymentMethodText = paymentMethodSelect.options[paymentMethodSelect.selectedIndex].text;
            paymentMethodDisplay.textContent = `: ${paymentMethodText}`;
        } else {
            paymentMethodDisplay.textContent = ': -';
        }
    }

    startDateInput.addEventListener('change', updateSummary);
    endDateInput.addEventListener('change', updateSummary);
    paymentMethodSelect.addEventListener('change', updateSummary);
});

</script>

<script>

</script>
@endsection
