@extends('layouts.mainlayout')
@section('title', 'Daftar')
@section('content4')

<div class="container">
    @include('layouts.pesan')
    <div class="d-flex justify-content-between align-items-center text-success">
        <h1 class="display-6">Daftar Program<br>Day Care</h1>
        <button class="btn btn-secondary" onclick="goBack()">
            <i class="bi bi-arrow-left"></i>Kembali
        </button>
    </div>
    <div class="row">
    <!-- Form Pilih Hari -->
        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body rounded text-success">
                    <p style="font-size: 30px;">Pilih Hari</p>
                    <form action="{{ route('daftarday') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="tanggal_mulai">Tanggal Mulai:</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tanggal_selesai">Tanggal Selesai:</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai">
                        </div>
                        <div id="programs">
                            <!-- Program selections will be dynamically added here -->
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="metodePembayaran">Metode Pembayaran</label>
                            <select class="form-control" id="metodePembayaran" name="metodePembayaran" required>
                                <option value="" disabled selected>Pilih Pembayaran</option>
                                <option value="Tunai">Tunai</option>
                                <option value="Transfer BRI">Transfer BRI</option>
                            </select>
                        </div>
                        <input type="hidden" id="summaryTotalPriceInput" name="summaryTotalPrice">
                        <button type="submit" class="btn btn-success" >Daftar</button>
                    </form>
                </div>
            </div>
        </div>
    <!-- Daftar Harga -->
        <div class="col-lg-7 offset-lg-1 text-success">
            <div class="mt-3" style="font-size: 30px;">Daftar Harga</div>
            <div class="card">
                <div class="card-body rounded bg-success text-white">
                    <div class="row">
                        <div class="col-8">
                            <p style="font-size: 20px; font-weight: bold;">Senin - Jum'at</p>
                        </div>
                        <div class="col-4">
                            <p style="font-size: 20px; font-weight: bold;">Harga Harian</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <p style="font-size: 20px; font-weight: 100;">Pagi (08.00-16.00) / Sore (16.00-21.00)</p>
                        </div>
                        <div class="col-4">
                            <p style="font-size: 20px; font-weight: 100;">Rp. 40.000</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <p style="font-size: 20px; font-weight: 100;">Pagi - Sore (Full Day) (08.00-21.00)</p>
                            <hr style="border: 0; border-top: 2px solid #ffffff;">
                        </div>
                        <div class="col-4">
                            <p style="font-size: 20px; font-weight: 100;">Rp. 80.000</p>
                            <hr style="border: 0; border-top: 2px solid #ffffff;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <p style="font-size: 20px; font-weight: bold;">Sabtu - Minggu</p>
                        </div>
                        <div class="col-4">
                            <p style="font-size: 20px; font-weight: bold;">Harga Harian</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <p style="font-size: 20px; font-weight: 100;">Pagi (08.00-16.00) / Sore (16.00-21.00)</p>
                        </div>
                        <div class="col-4">
                            <p style="font-size: 20px; font-weight: 100;">Rp. 50.000</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <p style="font-size: 20px; font-weight: 100;">Pagi - Sore (Full Day) (08.00-21.00)</p>
                        </div>
                        <div class="col-4">
                            <p style="font-size: 20px; font-weight: 100;">Rp. 100.000</p>
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
                    <!-- Ubah bagian ini untuk menampilkan Detail Pilihan Program -->
                    <tr>
                        <td scope="row" class="text-success">Detail Pilihan Program</td>
                        <td id="summaryProgram">
                            <ul id="selectedProgramsList"></ul> <!-- Menambahkan daftar pilihan program sebagai daftar terurut -->
                        </td>
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
                        <td id="summaryTotalPrice" name="summaryTotalPrice"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div> 
</div>
<script>
// Initialize the min and max dates for tanggal_mulai
const today = new Date().toLocaleString("en-US", { timeZone: "Asia/Jakarta" });
const todayDate = new Date(today);
const maxMulaiDate = new Date(todayDate);
maxMulaiDate.setDate(maxMulaiDate.getDate() + 7);

document.getElementById('tanggal_mulai').min = formatDateForInput(todayDate);
document.getElementById('tanggal_mulai').max = formatDateForInput(maxMulaiDate);

// Set initial max date for tanggal_selesai
const tanggalMulai = document.getElementById('tanggal_mulai').value;
const tanggalMulaiDate = new Date(tanggalMulai);
const initialMaxSelesaiDate = new Date(tanggalMulaiDate);
initialMaxSelesaiDate.setDate(initialMaxSelesaiDate.getDate() + 7);

document.getElementById('tanggal_selesai').max = formatDateForInput(initialMaxSelesaiDate);

// Event listener for tanggal_mulai to update tanggal_selesai
document.getElementById('tanggal_mulai').addEventListener('change', function() {
    // Set tanggal selesai minimal sama dengan tanggal mulai dan maksimal 1 minggu setelah tanggal mulai
    const selectedMulaiDate = new Date(this.value);
    const minSelesaiDate = new Date(selectedMulaiDate);
    const maxSelesaiDate = new Date(selectedMulaiDate);
    maxSelesaiDate.setDate(selectedMulaiDate.getDate() + 7);

    // Update min and max attributes of tanggal_selesai
    document.getElementById('tanggal_selesai').min = formatDateForInput(selectedMulaiDate);
    document.getElementById('tanggal_selesai').max = formatDateForInput(maxSelesaiDate);

    // Reset tanggal_selesai value if it's less than the new minimum date or greater than the new maximum date
    const selectedSelesaiDate = new Date(document.getElementById('tanggal_selesai').value);
    if (selectedSelesaiDate < selectedMulaiDate || selectedSelesaiDate > maxSelesaiDate) {
        document.getElementById('tanggal_selesai').value = formatDateForInput(selectedMulaiDate);
    }

    // Update program options
    updateProgramOptions();
});

// Add event listener for tanggal_selesai
document.getElementById('tanggal_selesai').addEventListener('change', updateProgramOptions);

// Add event listener for metodePembayaran to update summary
document.getElementById('metodePembayaran').addEventListener('change', updateSummary);

// Function to format date as DD-MM-YYYY
function formatDateForInput(date) {
    const d = new Date(date);
    let month = '' + (d.getMonth() + 1);
    let day = '' + d.getDate();
    const year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('-');
}

// Data program dari database
const programData = [
    { id: '111', nama: 'Day Care', tipe: 'pagi', harga: 40000 },
    { id: '112', nama: 'Day Care', tipe: 'sore', harga: 40000 },
    { id: '113', nama: 'Day Care', tipe: 'full_day', harga: 80000 },
    { id: '121', nama: 'Day Care', tipe: 'pagi', harga: 50000 },
    { id: '122', nama: 'Day Care', tipe: 'sore', harga: 50000 },
    { id: '123', nama: 'Day Care', tipe: 'full_day', harga: 100000 }
];

// Function to add program options to the dropdown
function addProgramOptions(select, currentDate) {
    const dayOfWeek = currentDate.getUTCDay();
    const isWeekend = (dayOfWeek === 0 || dayOfWeek === 6); // 0 = Minggu, 6 = Sabtu

    // Filter data based on weekend or weekday
    const filteredProgramData = programData.filter(program => {
        if (program.harga === 40000 || program.harga === 80000) {
            return !isWeekend;
        }
        return isWeekend;
    });

    filteredProgramData.forEach(program => {
        const option = document.createElement('option');
        option.value = program.id;
        option.textContent = `${program.nama} ${program.tipe} - Rp ${program.harga.toLocaleString()}`;
        option.dataset.harga = program.harga; // store harga in data attribute
        select.appendChild(option);
    });
}

// Function to update program options based on selected dates
function updateProgramOptions() {
    const tanggalMulaiInput = document.getElementById('tanggal_mulai');
    const tanggalSelesaiInput = document.getElementById('tanggal_selesai');
    const programsDiv = document.getElementById('programs');
    const daysInIndonesian = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

    if (tanggalMulaiInput.value && tanggalSelesaiInput.value) {
        const tanggalMulai = new Date(tanggalMulaiInput.value);
        const tanggalSelesai = new Date(tanggalSelesaiInput.value);
        programsDiv.innerHTML = '';

        if (!isNaN(tanggalMulai) && !isNaN(tanggalSelesai) && tanggalMulai <= tanggalSelesai) {
            let currentDate = new Date(tanggalMulai);
            while (currentDate <= tanggalSelesai) {
                const day = ('0' + currentDate.getDate()).slice(-2);
                const month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                const year = currentDate.getFullYear();
                const currentDateString = `${year}-${month}-${day}`;
                const currentDayIndex = currentDate.getDay();
                const currentDay = daysInIndonesian[currentDayIndex];
                const programOption = document.createElement('div');
                programOption.classList.add('mb-3');
                const label = document.createElement('label');
                label.classList.add('form-label');
                label.textContent = `Pilih program untuk hari ${currentDay}, ${currentDateString}:`;
                programOption.appendChild(label);
                const select = document.createElement('select');
                select.classList.add('form-control');
                select.name = `programs[${currentDateString}]`;
                select.required = true;
                select.dataset.date = currentDateString;
                addProgramOptions(select, currentDate);
                programOption.appendChild(select);
                programsDiv.appendChild(programOption);
                currentDate.setDate(currentDate.getDate() + 1);
            }
        }
    }
}

// Function to update the summary section
function updateSummary() {
    const tanggalMulai = document.getElementById('tanggal_mulai').value;
    const tanggalSelesai = document.getElementById('tanggal_selesai').value;
    const metodePembayaran = document.getElementById('metodePembayaran').value;

    document.getElementById('summaryStartDate').textContent = tanggalMulai;
    document.getElementById('summaryEndDate').textContent = tanggalSelesai;
    document.getElementById('paymentMethod').textContent = metodePembayaran;

    // Update selected programs
    const selectedProgramsList = document.getElementById('selectedProgramsList');
    const summaryCostDetails = document.getElementById('summaryCostDetails');
    selectedProgramsList.innerHTML = '';
    summaryCostDetails.innerHTML = '';

    const programSelects = document.querySelectorAll('#programs select');
    let totalPrice = 0;
    programSelects.forEach(select => {
        const selectedOption = select.options[select.selectedIndex];
        const date = select.dataset.date;
        const programText = selectedOption.textContent.split(' - ')[0];
        const harga = parseInt(selectedOption.dataset.harga);

        const li = document.createElement('li');
        li.textContent = `${date}: ${programText}`;
        selectedProgramsList.appendChild(li);

        const costLi = document.createElement('li');
        costLi.textContent = `${date}: Rp ${harga.toLocaleString()}`;
        summaryCostDetails.appendChild(costLi);

        totalPrice += harga;
    });

    document.getElementById('summaryTotalPrice').textContent = `Rp ${totalPrice.toLocaleString()}`;
    document.getElementById('summaryTotalPriceInput').value = totalPrice; // Update hidden input value
}

// Add event listeners to update summary when a program is selected
document.getElementById('programs').addEventListener('change', updateSummary);

// Initial call to update summary in case the form is pre-filled
updateSummary();

function goBack() {
        window.history.back();
    }
</script>
@endsection
