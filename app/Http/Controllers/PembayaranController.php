<?php

namespace App\Http\Controllers;

use App\Models\BuktiTrsk;
use App\Models\Transaksi;
use App\Models\Pendaftaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function bayarday()
    {
        // Ambil pendaftaran terakhir untuk user yang sedang login
        $pendaftaran = Pendaftaran::whereHas('dataPeserta', function($query) {
            $query->where('user_id', Auth::id());
        })->latest()->first();

        if (!$pendaftaran) {
            return redirect()->route('home')->with('error', 'Tidak ada pendaftaran ditemukan');
        }

        // Ambil transaksi terkait
        $transaksi = Transaksi::where('pendaftaran_id', $pendaftaran->id)->first();

        if (!$transaksi) {
            return redirect()->route('home')->with('error', 'Tidak ada transaksi ditemukan');
        }

        return view('layouts.pembayaran', [
            'transaksi' => $transaksi,
            'pendaftaran' => $pendaftaran,
            'programs' => $pendaftaran->program
        ]);
    }

    public function cetakBuktiPendaftaran($id)
    {
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

    public function uploadBuktiPembayaran(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:jpg,png,jpeg,pdf|max:2048',
        ],[
            'bukti_pembayaran.max' => 'Maksimal file yang diupload 2 MB'
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $path = $file->store('bukti_pembayaran', 'public');

            $transaksi = Transaksi::where('pendaftaran_id', $pendaftaran->id)->first();

            // Simpan informasi file ke tabel bukti_trsk
            BuktiTrsk::updateOrCreate(
                ['transaksi_id' => $transaksi->id],
                ['nama_file' => $path, 'tanggal_upload' => now()]
            );
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload');
    }
}
