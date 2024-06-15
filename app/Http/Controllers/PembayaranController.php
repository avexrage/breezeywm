<?php

namespace App\Http\Controllers;

use App\Models\BuktiTransaksi;
use App\Models\Transaksi;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class PembayaranController extends Controller
{
    public function bayar(){
    // Ambil semua pendaftaran untuk user yang sedang login
    $pendaftaranList = Pendaftaran::whereHas('peserta', function ($query) {
        $query->where('user_id', Auth::id());
    })->orderBy('created_at', 'desc')->get();

    // Filter pendaftaran dengan transaksi yang belum lunas
    $unpaidTransactions = [];
    foreach ($pendaftaranList as $pendaftaran) {
        $transaksi = Transaksi::where('pendaftaran_id', $pendaftaran->id)
            ->where('status_pembayaran', '!=', 'Lunas')
            ->first();

       // Asumsi durasi ada di relasi pivot
        $durasi = $pendaftaran->program->first()->pivot->durasi ?? null;
        
        if ($transaksi) {
            $unpaidTransactions[] = [
                'pendaftaran' => $pendaftaran,
                'transaksi' => $transaksi,
                'nama_program' => $pendaftaran->program->first()->nama_program,
                'programs' => $pendaftaran->program,
                'check_in' => $pendaftaran->check_in,
                'check_out' => $pendaftaran->check_out,
                'nama_lengkap_peserta' =>  $pendaftaran->peserta->nama_lengkap_peserta,
                'durasi' => $durasi,
            ];
        }
    }

    // Jika tidak ada transaksi yang belum lunas, kirim variabel sebagai null
    if (empty($unpaidTransactions)) {
        return view('layouts.pembayaran', [
            'unpaidTransactions' => null
        ]);
    }

    return view('layouts.pembayaran', [
        'unpaidTransactions' => $unpaidTransactions
        ]);
    }

    public function pilihMetode(Request $request, $id)
{
    $validated = $request->validate([
        'metodePembayaran' => 'required|string',
    ]);

    $pendaftaran = Pendaftaran::findOrFail($id);
    $pendaftaran->metode_pembayaran = $validated['metodePembayaran'];
    $pendaftaran->save();

    // Redirect ke halaman pembayaran dengan pesan sukses
    return redirect()->route('bayar')->with('success', 'Metode pembayaran berhasil dipilih.');
}

    public function cetakBuktiPendaftaran($id){
        $pendaftaran = Pendaftaran::findOrFail($id);
        $transaksi = Transaksi::where('pendaftaran_id', $pendaftaran->id)->first();

        $data = [
            'transaksi' => $transaksi,
            'pendaftaran' => $pendaftaran,
            'programs' => $pendaftaran->program,
        ];

        $pdf = PDF::loadView('pdf.bukti_pendaftaran', $data); // Menggunakan alias PDF
        return $pdf->download('bukti_pendaftaran.pdf');
    }

    public function uploadBuktiPembayaran(Request $request, $id){
        $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:jpg,png,jpeg,pdf|max:2048',
        ],[
            'bukti_pembayaran.max' => 'Maksimal file yang diupload 2 MB',
            'bukti_pembayaran.file' => 'Tipe file bukti pembayaran antara jpg, png, jpeg, pdf',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $path = $file->store('bukti_pembayaran', 'public');

            $transaksi = Transaksi::where('pendaftaran_id', $pendaftaran->id)->first();

            // Simpan informasi file ke tabel bukti_trsk
            BuktiTransaksi::updateOrCreate(
                ['transaksi_id' => $transaksi->id],
                ['nama_file' => $path, 'tanggal_upload' => now()]
            );
            
            // Update status pembayaran menjadi "Menunggu Verifikasi Admin"
            $transaksi->status_pembayaran = 'Menunggu Verifikasi Admin';
            $transaksi->tanggal_transaksi = now();
            $transaksi->save();
            
        }
        return redirect()->route('bayar')->with('success', 'Bukti pembayaran berhasil diupload, Admin akan memverifikasi pembayaran Anda');
    }
}
