<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Mail\StatusPendaftaranMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function showLoginForm(){
        return view('admin.admin-login');
    }

    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->intended(route('admin'));
        }

        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function adminLogout(){
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }

//Pendaftaran Day
    public function showPendaftaranDay(Request $request) {
        $query = DB::table('data_peserta')
            ->join('user', 'data_peserta.user_id', '=', 'user.id')
            ->leftJoin('asuransi', 'data_peserta.id', '=', 'asuransi.data_peserta_id')
            ->leftJoin('pendaftaran', 'data_peserta.id', '=', 'pendaftaran.data_peserta_id')
            ->leftJoin('detail_pendaftaran', 'pendaftaran.id', '=', 'detail_pendaftaran.pendaftaran_id')
            ->leftJoin('program', 'detail_pendaftaran.program_id', '=', 'program.id_program')
            ->select(
                'pendaftaran.id as pendaftaran_id',
                'data_peserta.nama_lengkap_peserta',
                'data_peserta.ktp as nomor_ktp_peserta',
                'data_peserta.alamat as alamat_peserta',
                'data_peserta.tempat_lahir as tempat_lahir_peserta',
                'data_peserta.tanggal_lahir as tanggal_lahir_peserta',
                'data_peserta.jenis_kelamin as jenis_kelamin_peserta',
                'data_peserta.agama as agama_peserta',
                'data_peserta.statusnikah as status_nikah_peserta',
                'data_peserta.pekerjaan as pekerjaan_peserta',
                'data_peserta.keahlian as keahlian_peserta',
                'data_peserta.hobi as hobi_peserta',
                'data_peserta.bahasa as bahasa_peserta',
                'data_peserta.riwayat_penyakit as riwayat_penyakit_peserta',
                'asuransi.nama_asuransi as nama_asuransi',
                'asuransi.no_asuransi as no_asuransi',
                'user.ktp as nomor_ktp_penanggung_jawab',
                'user.nama as nama_penanggung_jawab',
                'user.email as email_penanggung_jawab',
                'user.alamat as alamat_penanggung_jawab',
                'user.no_hp as nomor_hp_penanggung_jawab',
                'user.pekerjaan as pekerjaan_penanggung_jawab',
                'pendaftaran.created_at as tanggal_daftar',
                'pendaftaran.status_pendaftaran',
                'pendaftaran.check_in',
                'pendaftaran.check_out',
                'pendaftaran.alasan',
                'program.nama_program as program',
                'detail_pendaftaran.tanggal',
                'detail_pendaftaran.harga',
                'detail_pendaftaran.tipe as waktu',
                'detail_pendaftaran.durasi'
            )
            ->where('program.nama_program', 'LIKE', '%Day Care%');
    
        if ($request->has('search')) {
            $query->where('data_peserta.nama_lengkap_peserta', 'like', '%' . $request->search . '%');
        }
    
        $pendaftaranPaginated = $query->orderBy('pendaftaran.created_at', 'desc')->paginate(11);
    
        // Mengelompokkan data berdasarkan pendaftaran_id
        $groupedData = collect($pendaftaranPaginated->items())
            ->groupBy('pendaftaran_id')
            ->map(function ($row) {
                return [
                    'pendaftaran_id' => $row->first()->pendaftaran_id,
                    'nama_lengkap_peserta' => $row->first()->nama_lengkap_peserta,
                    'nomor_ktp_peserta' => $row->first()->nomor_ktp_peserta,
                    'alamat_peserta' => $row->first()->alamat_peserta,
                    'tempat_lahir_peserta' => $row->first()->tempat_lahir_peserta,
                    'tanggal_lahir_peserta' => $row->first()->tanggal_lahir_peserta,
                    'jenis_kelamin_peserta' => $row->first()->jenis_kelamin_peserta,
                    'agama_peserta' => $row->first()->agama_peserta,
                    'status_nikah_peserta' => $row->first()->status_nikah_peserta,
                    'pekerjaan_peserta' => $row->first()->pekerjaan_peserta,
                    'keahlian_peserta' => $row->first()->keahlian_peserta,
                    'hobi_peserta' => $row->first()->hobi_peserta,
                    'bahasa_peserta' => $row->first()->bahasa_peserta,
                    'riwayat_penyakit_peserta' => $row->first()->riwayat_penyakit_peserta,
                    'nama_asuransi' => $row->first()->nama_asuransi,
                    'no_asuransi' => $row->first()->no_asuransi,
                    'nomor_ktp_penanggung_jawab' => $row->first()->nomor_ktp_penanggung_jawab,
                    'nama_penanggung_jawab' => $row->first()->nama_penanggung_jawab,
                    'email_penanggung_jawab' => $row->first()->email_penanggung_jawab,
                    'alamat_penanggung_jawab' => $row->first()->alamat_penanggung_jawab,
                    'nomor_hp_penanggung_jawab' => $row->first()->nomor_hp_penanggung_jawab,
                    'pekerjaan_penanggung_jawab' => $row->first()->pekerjaan_penanggung_jawab,
                    'tanggal_daftar' => $row->first()->tanggal_daftar,
                    'status_pendaftaran' => $row->first()->status_pendaftaran,
                    'check_in' => $row->first()->check_in,
                    'check_out' => $row->first()->check_out,
                    'alasan' => $row->first()->alasan,
                    'program' => $row->first()->program,
                    'program_details' => $row->sortBy('tanggal')->values()->map(function ($detail) {
                        return [
                            'tanggal' => $detail->tanggal,
                            'harga' => $detail->harga,
                            'waktu' => $detail->waktu,
                            'durasi' => $detail->durasi
                        ];
                    })
                ];
            });
    
        // Mengganti koleksi dari paginator dengan data yang dikelompokkan
        $paginatedGroupedData = new \Illuminate\Pagination\LengthAwarePaginator(
            $groupedData->values(),
            $pendaftaranPaginated->total(),
            $pendaftaranPaginated->perPage(),
            $pendaftaranPaginated->currentPage(),
            ['path' => request()->url(), 'query' => request()->query()]
        );
    
        return view('admin.data-pendaftaran-day', ['pendaftaranDay' => $paginatedGroupedData]);
    }
    
    public function showCetakPdftrDay(){
        return view('admin.cetak-pendaftaran-day');
    }

    public function cetakPendaftaranDay(Request $request){
        // Validasi input
        $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date'
            ], [
                'start_date.required' => 'Tanggal Awal Pendaftaran Wajib diisi',
                'start_date.date' => 'Tanggal Awal Pendaftaran harus berupa tanggal yang valid',
                'end_date.required' => 'Tanggal Akhir Pendaftaran Wajib diisi',
                'end_date.date' => 'Tanggal Akhir Pendaftaran harus berupa tanggal yang valid'
            ]);

                $startDate = $request->get('start_date');
                $endDate = $request->get('end_date');
            $pendaftaran = DB::table('data_peserta')
            ->join('user', 'data_peserta.user_id', '=', 'user.id')
            ->leftJoin('asuransi', 'data_peserta.id', '=', 'asuransi.data_peserta_id')
            ->leftJoin('pendaftaran', 'data_peserta.id', '=', 'pendaftaran.data_peserta_id')
            ->leftJoin('detail_pendaftaran', 'pendaftaran.id', '=', 'detail_pendaftaran.pendaftaran_id')
            ->leftJoin('program', 'detail_pendaftaran.program_id', '=', 'program.id_program')
            ->select(
                'pendaftaran.id as pendaftaran_id',
                'data_peserta.nama_lengkap_peserta',
                'asuransi.nama_asuransi',
                'asuransi.no_asuransi',
                'pendaftaran.created_at as tanggal_daftar',
                'pendaftaran.status_pendaftaran',
                'pendaftaran.check_in',
                'pendaftaran.check_out',
                'program.nama_program as program',
                'detail_pendaftaran.tanggal',
                'detail_pendaftaran.harga',
                'detail_pendaftaran.tipe as waktu'
            )
            ->whereDate('pendaftaran.created_at', '>=', $startDate)
            ->whereDate('pendaftaran.created_at', '<=', $endDate)
            ->where('program.nama_program', 'LIKE', '%Day Care%')
            ->orderBy('pendaftaran.created_at', 'desc')
            ->get();

            $groupedData = $pendaftaran->groupBy('pendaftaran_id')->map(function ($row) {
                return [
                    'nama_lengkap_peserta' => $row->first()->nama_lengkap_peserta,
                    'nama_asuransi' => $row->first()->nama_asuransi,
                    'no_asuransi' => $row->first()->no_asuransi,
                    'tanggal_daftar' => $row->first()->tanggal_daftar,
                    'status_pendaftaran' => $row->first()->status_pendaftaran,
                    'check_in' => $row->first()->check_in,
                    'check_out' => $row->first()->check_out,
                    'program_details' => $row->sortBy('tanggal')->values()->map(function ($detail) {
                        return [
                            'tanggal' => $detail->tanggal,
                            'harga' => $detail->harga,
                            'waktu' => $detail->waktu
                        ];
                    })
                ];
            });

        $pdf = Pdf::loadView('pdf.cetakdatapdftrday', [
        'groupedData' => $groupedData, 
        'startDate' => $startDate, 
        'endDate' => $endDate])
        ->setPaper('a4', 'landscape'); // Set orientation to landscape

        return $pdf->stream('cetakdatapdftrday.pdf'); // Menampilkan PDF di browser
    }

    public function updatePendaftaranDay(Request $request){
        // Validate the input data
        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftaran,id',
            'status_pendaftaran' => 'required|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date'
        ]);

        // Find the pendaftaran record by ID
        $pendaftaran = Pendaftaran::findOrFail($request->pendaftaran_id);

        // Update the pendaftaran record with the new data
        $pendaftaran->status_pendaftaran = $request->status_pendaftaran;

        if ($request->check_in) {
            $pendaftaran->check_in = Carbon::parse($request->check_in);
        }

        if ($request->check_out) {
            $pendaftaran->check_out = Carbon::parse($request->check_out);
        }

        $pendaftaran->save();

        // Redirect back with a success message
        return redirect()->route('datapdftrday')
                         ->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

//Pendaftaran Grha
    public function showPendaftaranGrha(Request $request){
        $query = DB::table('data_peserta')
            ->join('user', 'data_peserta.user_id', '=', 'user.id')
            ->leftJoin('asuransi', 'data_peserta.id', '=', 'asuransi.data_peserta_id')
            ->leftJoin('pendaftaran', 'data_peserta.id', '=', 'pendaftaran.data_peserta_id')
            ->leftJoin('detail_pendaftaran', 'pendaftaran.id', '=', 'detail_pendaftaran.pendaftaran_id')
            ->leftJoin('program', 'detail_pendaftaran.program_id', '=', 'program.id_program')
            ->leftJoin('video', 'data_peserta.id', '=', 'video.data_peserta_id')
            ->select(
                'pendaftaran.id as pendaftaran_id',
                'data_peserta.nama_lengkap_peserta',
                'data_peserta.ktp as nomor_ktp_peserta',
                'data_peserta.alamat as alamat_peserta',
                'data_peserta.tempat_lahir as tempat_lahir_peserta',
                'data_peserta.tanggal_lahir as tanggal_lahir_peserta',
                'data_peserta.jenis_kelamin as jenis_kelamin_peserta',
                'data_peserta.agama as agama_peserta',
                'data_peserta.statusnikah as status_nikah_peserta',
                'data_peserta.pekerjaan as pekerjaan_peserta',
                'data_peserta.keahlian as keahlian_peserta',
                'data_peserta.hobi as hobi_peserta',
                'data_peserta.bahasa as bahasa_peserta',
                'data_peserta.riwayat_penyakit as riwayat_penyakit_peserta',
                'asuransi.nama_asuransi as nama_asuransi',
                'asuransi.no_asuransi as no_asuransi',
                'user.ktp as nomor_ktp_penanggung_jawab',
                'user.nama as nama_penanggung_jawab',
                'user.email as email_penanggung_jawab',
                'user.alamat as alamat_penanggung_jawab',
                'user.no_hp as nomor_hp_penanggung_jawab',
                'user.pekerjaan as pekerjaan_penanggung_jawab',
                'pendaftaran.created_at as tanggal_daftar',
                'pendaftaran.status_pendaftaran',
                'pendaftaran.check_in',
                'pendaftaran.check_out',
                'pendaftaran.alasan',
                'program.nama_program as program',
                'detail_pendaftaran.tanggal',
                'detail_pendaftaran.harga',
                'detail_pendaftaran.tipe as wisma',
                'detail_pendaftaran.durasi',
                'video.nama_file as video_file'
            )
            ->where('program.nama_program', 'LIKE', '%Grha Wredha Mulya%');
    
        if ($request->has('search')) {
            $query->where('data_peserta.nama_lengkap_peserta', 'like', '%' . $request->search . '%');
        }
    
        $pendaftaranPaginated = $query->orderBy('pendaftaran.created_at', 'desc')->paginate(11);

        return view('admin.data-pendaftaran-grha', ['pendaftaranGrha' => $pendaftaranPaginated]);
    }
    
    public function showCetakPdftrGrha(){
        return view('admin.cetak-pendaftaran-grha');
    }

    public function cetakPendaftaranGrha(Request $request){
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ], [
            'start_date.required' => 'Tanggal Awal Pendaftaran Wajib diisi',
            'start_date.date' => 'Tanggal Awal Pendaftaran harus berupa tanggal yang valid',
            'end_date.required' => 'Tanggal Akhir Pendaftaran Wajib diisi',
            'end_date.date' => 'Tanggal Akhir Pendaftaran harus berupa tanggal yang valid'
        ]);
            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');

        $pendaftaranGrha = DB::table('data_peserta')
            ->join('user', 'data_peserta.user_id', '=', 'user.id')
            ->leftJoin('asuransi', 'data_peserta.id', '=', 'asuransi.data_peserta_id')
            ->leftJoin('pendaftaran', 'data_peserta.id', '=', 'pendaftaran.data_peserta_id')
            ->leftJoin('detail_pendaftaran', 'pendaftaran.id', '=', 'detail_pendaftaran.pendaftaran_id')
            ->leftJoin('program', 'detail_pendaftaran.program_id', '=', 'program.id_program')
            ->select(
                'pendaftaran.id as pendaftaran_id',
                'data_peserta.nama_lengkap_peserta',
                'asuransi.nama_asuransi',
                'asuransi.no_asuransi',
                'pendaftaran.created_at as tanggal_daftar',
                'pendaftaran.status_pendaftaran',
                'pendaftaran.check_in',
                'pendaftaran.check_out',
                'program.nama_program as program',
                'detail_pendaftaran.harga',
                'detail_pendaftaran.tipe as wisma',
                'detail_pendaftaran.durasi'
            )
            ->whereDate('pendaftaran.created_at', '>=', $startDate)
            ->whereDate('pendaftaran.created_at', '<=', $endDate)
            ->where('program.nama_program', 'LIKE', '%Grha Wredha Mulya%')
            ->orderBy('pendaftaran.created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('pdf.cetakdatapdftrgrha', [
        'pendaftaranGrha' => $pendaftaranGrha, 
        'startDate' => $startDate, 
        'endDate' => $endDate])
        ->setPaper('a4', 'landscape'); // Set orientation to landscape

        return $pdf->stream('cetakdatapdftrgrha.pdf'); // Menampilkan PDF di browser
    }

    public function updatePendaftaranGrha(Request $request){
        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftaran,id',
            'status_pendaftaran' => 'required|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'alasan' => 'nullable|string'
        
        ]);
    
        // Cari record pendaftaran berdasarkan ID
        $pendaftaran = Pendaftaran::findOrFail($request->pendaftaran_id);
    
        // Update record pendaftaran dengan data baru
        $pendaftaran->status_pendaftaran = $request->status_pendaftaran;
    
        if ($request->has('clear_tanggal_mulai')) {
            $pendaftaran->check_in = null;
        } else if ($request->tanggal_mulai) {
            $pendaftaran->check_in = Carbon::parse($request->tanggal_mulai);
        }
    
        if ($request->has('clear_tanggal_selesai')) {
            $pendaftaran->check_out = null;
        } else if ($request->tanggal_selesai) {
            $pendaftaran->check_out = Carbon::parse($request->tanggal_selesai);
        }
    
        // Update alasan field
        $pendaftaran->alasan = $request->alasan;
        $pendaftaran->save();

        // Ambil email user yang terkait dengan pendaftaran melalui relasi dataPeserta
        $user = $pendaftaran->dataPeserta->user;

        // Periksa apakah user ditemukan
        if (!$user) {
            return redirect()->route('datapdftrgrha')
                            ->with('error', 'Pengguna terkait tidak ditemukan.');
        }

        // Kirim email berdasarkan status pendaftaran baru
        if ($request->status_pendaftaran == 'Menunggu Jadwal') {
            Mail::to($user->email)->send(new StatusPendaftaranMail('Menunggu Jadwal', 'Status Pendaftaran Anda sudah diterima tapi masih MENUNGGU JADWAL, harap cek berkala di website atau hubungi Nomor Whatsapp Admin: wa.me/+62895391232829.'));
        } elseif ($request->status_pendaftaran == 'Diterima') {
            Mail::to($user->email)->send(new StatusPendaftaranMail('Diterima', 'Status Pendaftaran sudah DITERIMA, silahkan lanjutkan pembayaran.'));
        } elseif ($request->status_pendaftaran == 'Ditolak') {
            Mail::to($user->email)->send(new StatusPendaftaranMail('Ditolak', 'Status Pendaftaran Anda sudah DITOLAK, dengan alasan: ' . $request->alasan));
        } elseif ($request->status_pendaftaran == 'Dibatalkan') {
            Mail::to($user->email)->send(new StatusPendaftaranMail('Dibatalkan', 'Status Pendaftaran Anda telah DIBATALKAN, dengan alasan: ' . $request->alasan));
        }
    
        // Redirect kembali dengan pesan sukses
        return redirect()->route('datapdftrgrha')
                         ->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

//Pembayaran Day
    public function showPembayaranDay(){
        return view('admin.data-pembayaran-day');
    }
    
    public function showCetakPbyrDay(){
        return view('admin.cetak-pembayaran-day');
    }

    public function cetakPembayaranDay(Request $request){
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

    $pendaftaran = DB::table('data_peserta')
        ->join('user', 'data_peserta.user_id', '=', 'user.id')
        ->leftJoin('asuransi', 'data_peserta.id', '=', 'asuransi.data_peserta_id')
        ->leftJoin('pendaftaran', 'data_peserta.id', '=', 'pendaftaran.data_peserta_id')
        ->leftJoin('detail_pendaftaran', 'pendaftaran.id', '=', 'detail_pendaftaran.pendaftaran_id')
        ->leftJoin('program', 'detail_pendaftaran.program_id', '=', 'program.id_program')
        ->select(
            'pendaftaran.id as pendaftaran_id',
            'data_peserta.nama_lengkap_peserta',
            'asuransi.nama_asuransi',
            'asuransi.no_asuransi',
            'pendaftaran.created_at as tanggal_daftar',
            'pendaftaran.status_pendaftaran',
            'pendaftaran.check_in',
            'pendaftaran.check_out',
            'program.nama_program as program',
            'detail_pendaftaran.tanggal',
            'detail_pendaftaran.harga',
            'detail_pendaftaran.tipe as waktu'
        )
        ->whereDate('pendaftaran.created_at', '>=', $startDate)
        ->whereDate('pendaftaran.created_at', '<=', $endDate)
        ->where('program.nama_program', 'LIKE', '%Day Care%')
        ->orderBy('pendaftaran.created_at', 'desc')
        ->get();

        $groupedData = $pendaftaran->groupBy('pendaftaran_id')->map(function ($row) {
            return [
                'nama_lengkap_peserta' => $row->first()->nama_lengkap_peserta,
                'nama_asuransi' => $row->first()->nama_asuransi,
                'no_asuransi' => $row->first()->no_asuransi,
                'tanggal_daftar' => $row->first()->tanggal_daftar,
                'status_pendaftaran' => $row->first()->status_pendaftaran,
                'check_in' => $row->first()->check_in,
                'check_out' => $row->first()->check_out,
                'program_details' => $row->sortBy('tanggal')->values()->map(function ($detail) {
                    return [
                        'tanggal' => $detail->tanggal,
                        'harga' => $detail->harga,
                        'waktu' => $detail->waktu
                    ];
                })
            ];
        });

    $pdf = Pdf::loadView('pdf.cetakdatapdftr', [
        'groupedData' => $groupedData, 
        'startDate' => $startDate, 
        'endDate' => $endDate])
        ->setPaper('a4', 'landscape'); // Set orientation to landscape

        return $pdf->stream('cetakdatapdftr.pdf'); // Menampilkan PDF di browser
    }

    public function updatePembayaranDay(Request $request){
        // Validate the input data
        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftaran,id',
            'status_pendaftaran' => 'required|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date'
        ]);

        // Find the pendaftaran record by ID
        $pendaftaran = Pendaftaran::findOrFail($request->pendaftaran_id);

        // Update the pendaftaran record with the new data
        $pendaftaran->status_pendaftaran = $request->status_pendaftaran;

        if ($request->tanggal_mulai) {
            $pendaftaran->tanggal_mulai = Carbon::parse($request->tanggal_mulai);
        }

        if ($request->tanggal_selesai) {
            $pendaftaran->tanggal_selesai = Carbon::parse($request->tanggal_selesai);
        }

        $pendaftaran->save();

        // Redirect back with a success message
        return redirect()->route('datapbyr')
                         ->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

//Pembayaran Grha
    public function showPembayaranGrha(){
        return view('admin.data-pembayaran-grha');
    }
    
    public function showCetakPbyrGrha(){
        return view('admin.cetak-pembayaran-grha');
    }

    public function cetakPembayaranGrha(Request $request){
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

    $pendaftaran = DB::table('data_peserta')
        ->join('user', 'data_peserta.user_id', '=', 'user.id')
        ->leftJoin('asuransi', 'data_peserta.id', '=', 'asuransi.data_peserta_id')
        ->leftJoin('pendaftaran', 'data_peserta.id', '=', 'pendaftaran.data_peserta_id')
        ->leftJoin('detail_pendaftaran', 'pendaftaran.id', '=', 'detail_pendaftaran.pendaftaran_id')
        ->leftJoin('program', 'detail_pendaftaran.program_id', '=', 'program.id_program')
        ->select(
            'pendaftaran.id as pendaftaran_id',
            'data_peserta.nama_lengkap_peserta',
            'asuransi.nama_asuransi',
            'asuransi.no_asuransi',
            'pendaftaran.created_at as tanggal_daftar',
            'pendaftaran.status_pendaftaran',
            'pendaftaran.check_in',
            'pendaftaran.check_out',
            'program.nama_program as program',
            'detail_pendaftaran.tanggal',
            'detail_pendaftaran.harga',
            'detail_pendaftaran.tipe as waktu'
        )
        ->whereDate('pendaftaran.created_at', '>=', $startDate)
        ->whereDate('pendaftaran.created_at', '<=', $endDate)
        ->where('program.nama_program', 'LIKE', '%Day Care%')
        ->orderBy('pendaftaran.created_at', 'desc')
        ->get();

        $groupedData = $pendaftaran->groupBy('pendaftaran_id')->map(function ($row) {
            return [
                'nama_lengkap_peserta' => $row->first()->nama_lengkap_peserta,
                'nama_asuransi' => $row->first()->nama_asuransi,
                'no_asuransi' => $row->first()->no_asuransi,
                'tanggal_daftar' => $row->first()->tanggal_daftar,
                'status_pendaftaran' => $row->first()->status_pendaftaran,
                'check_in' => $row->first()->check_in,
                'check_out' => $row->first()->check_out,
                'program_details' => $row->sortBy('tanggal')->values()->map(function ($detail) {
                    return [
                        'tanggal' => $detail->tanggal,
                        'harga' => $detail->harga,
                        'waktu' => $detail->waktu
                    ];
                })
            ];
        });

    $pdf = Pdf::loadView('pdf.cetakdatapdftr', [
        'groupedData' => $groupedData, 
        'startDate' => $startDate, 
        'endDate' => $endDate])
        ->setPaper('a4', 'landscape'); // Set orientation to landscape

        return $pdf->stream('cetakdatapdftr.pdf'); // Menampilkan PDF di browser
    }

    public function updatePembayaranGrha(Request $request){
        // Validate the input data
        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftaran,id',
            'status_pendaftaran' => 'required|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date'
        ]);

        // Find the pendaftaran record by ID
        $pendaftaran = Pendaftaran::findOrFail($request->pendaftaran_id);

        // Update the pendaftaran record with the new data
        $pendaftaran->status_pendaftaran = $request->status_pendaftaran;

        if ($request->tanggal_mulai) {
            $pendaftaran->tanggal_mulai = Carbon::parse($request->tanggal_mulai);
        }

        if ($request->tanggal_selesai) {
            $pendaftaran->tanggal_selesai = Carbon::parse($request->tanggal_selesai);
        }

        $pendaftaran->save();

        // Redirect back with a success message
        return redirect()->route('datapbyr')
                         ->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

//Peserta Day
    public function showPesertaDay(){
        return view('admin.data-peserta-day');
    }

    public function showCetakPsrtDay(){
        return view('admin.cetak-peserta-day');
    }

    public function cetakPesertaDay(Request $request){
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

    $pendaftaran = DB::table('data_peserta')
        ->join('user', 'data_peserta.user_id', '=', 'user.id')
        ->leftJoin('asuransi', 'data_peserta.id', '=', 'asuransi.data_peserta_id')
        ->leftJoin('pendaftaran', 'data_peserta.id', '=', 'pendaftaran.data_peserta_id')
        ->leftJoin('detail_pendaftaran', 'pendaftaran.id', '=', 'detail_pendaftaran.pendaftaran_id')
        ->leftJoin('program', 'detail_pendaftaran.program_id', '=', 'program.id_program')
        ->select(
            'pendaftaran.id as pendaftaran_id',
            'data_peserta.nama_lengkap_peserta',
            'asuransi.nama_asuransi',
            'asuransi.no_asuransi',
            'pendaftaran.created_at as tanggal_daftar',
            'pendaftaran.status_pendaftaran',
            'pendaftaran.check_in',
            'pendaftaran.check_out',
            'program.nama_program as program',
            'detail_pendaftaran.tanggal',
            'detail_pendaftaran.harga',
            'detail_pendaftaran.tipe as waktu'
        )
        ->whereDate('pendaftaran.created_at', '>=', $startDate)
        ->whereDate('pendaftaran.created_at', '<=', $endDate)
        ->where('program.nama_program', 'LIKE', '%Day Care%')
        ->orderBy('pendaftaran.created_at', 'desc')
        ->get();

        $groupedData = $pendaftaran->groupBy('pendaftaran_id')->map(function ($row) {
            return [
                'nama_lengkap_peserta' => $row->first()->nama_lengkap_peserta,
                'nama_asuransi' => $row->first()->nama_asuransi,
                'no_asuransi' => $row->first()->no_asuransi,
                'tanggal_daftar' => $row->first()->tanggal_daftar,
                'status_pendaftaran' => $row->first()->status_pendaftaran,
                'check_in' => $row->first()->check_in,
                'check_out' => $row->first()->check_out,
                'program_details' => $row->sortBy('tanggal')->values()->map(function ($detail) {
                    return [
                        'tanggal' => $detail->tanggal,
                        'harga' => $detail->harga,
                        'waktu' => $detail->waktu
                    ];
                })
            ];
        });

    $pdf = Pdf::loadView('pdf.cetakdatapdftr', [
        'groupedData' => $groupedData, 
        'startDate' => $startDate, 
        'endDate' => $endDate])
        ->setPaper('a4', 'landscape'); // Set orientation to landscape

        return $pdf->stream('cetakdatapdftr.pdf'); // Menampilkan PDF di browser
    }

    public function updatePesertaDay(Request $request){
        // Validate the input data
        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftaran,id',
            'status_pendaftaran' => 'required|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date'
        ]);

        // Find the pendaftaran record by ID
        $pendaftaran = Pendaftaran::findOrFail($request->pendaftaran_id);

        // Update the pendaftaran record with the new data
        $pendaftaran->status_pendaftaran = $request->status_pendaftaran;

        if ($request->tanggal_mulai) {
            $pendaftaran->tanggal_mulai = Carbon::parse($request->tanggal_mulai);
        }

        if ($request->tanggal_selesai) {
            $pendaftaran->tanggal_selesai = Carbon::parse($request->tanggal_selesai);
        }

        $pendaftaran->save();

        // Redirect back with a success message
        return redirect()->route('datapbyr')
                         ->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

//Peserta Grha
    public function showPesertaGrha(){
        return view('admin.data-peserta-day');
    }

    public function showCetakPsrtGrha(){
        return view('admin.cetak-peserta-day');
    }

    public function cetakPesertaGrha(Request $request){
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

    $pendaftaran = DB::table('data_peserta')
        ->join('user', 'data_peserta.user_id', '=', 'user.id')
        ->leftJoin('asuransi', 'data_peserta.id', '=', 'asuransi.data_peserta_id')
        ->leftJoin('pendaftaran', 'data_peserta.id', '=', 'pendaftaran.data_peserta_id')
        ->leftJoin('detail_pendaftaran', 'pendaftaran.id', '=', 'detail_pendaftaran.pendaftaran_id')
        ->leftJoin('program', 'detail_pendaftaran.program_id', '=', 'program.id_program')
        ->select(
            'pendaftaran.id as pendaftaran_id',
            'data_peserta.nama_lengkap_peserta',
            'asuransi.nama_asuransi',
            'asuransi.no_asuransi',
            'pendaftaran.created_at as tanggal_daftar',
            'pendaftaran.status_pendaftaran',
            'pendaftaran.check_in',
            'pendaftaran.check_out',
            'program.nama_program as program',
            'detail_pendaftaran.tanggal',
            'detail_pendaftaran.harga',
            'detail_pendaftaran.tipe as waktu'
        )
        ->whereDate('pendaftaran.created_at', '>=', $startDate)
        ->whereDate('pendaftaran.created_at', '<=', $endDate)
        ->where('program.nama_program', 'LIKE', '%Day Care%')
        ->orderBy('pendaftaran.created_at', 'desc')
        ->get();

        $groupedData = $pendaftaran->groupBy('pendaftaran_id')->map(function ($row) {
            return [
                'nama_lengkap_peserta' => $row->first()->nama_lengkap_peserta,
                'nama_asuransi' => $row->first()->nama_asuransi,
                'no_asuransi' => $row->first()->no_asuransi,
                'tanggal_daftar' => $row->first()->tanggal_daftar,
                'status_pendaftaran' => $row->first()->status_pendaftaran,
                'check_in' => $row->first()->check_in,
                'check_out' => $row->first()->check_out,
                'program_details' => $row->sortBy('tanggal')->values()->map(function ($detail) {
                    return [
                        'tanggal' => $detail->tanggal,
                        'harga' => $detail->harga,
                        'waktu' => $detail->waktu
                    ];
                })
            ];
        });

    $pdf = Pdf::loadView('pdf.cetakdatapdftr', [
        'groupedData' => $groupedData, 
        'startDate' => $startDate, 
        'endDate' => $endDate])
        ->setPaper('a4', 'landscape'); // Set orientation to landscape

        return $pdf->stream('cetakdatapdftr.pdf'); // Menampilkan PDF di browser
    }

    public function updatePesertaGrha(Request $request){
        // Validate the input data
        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftaran,id',
            'status_pendaftaran' => 'required|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date'
        ]);

        // Find the pendaftaran record by ID
        $pendaftaran = Pendaftaran::findOrFail($request->pendaftaran_id);

        // Update the pendaftaran record with the new data
        $pendaftaran->status_pendaftaran = $request->status_pendaftaran;

        if ($request->tanggal_mulai) {
            $pendaftaran->tanggal_mulai = Carbon::parse($request->tanggal_mulai);
        }

        if ($request->tanggal_selesai) {
            $pendaftaran->tanggal_selesai = Carbon::parse($request->tanggal_selesai);
        }

        $pendaftaran->save();

        // Redirect back with a success message
        return redirect()->route('datapbyr')
                         ->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

}
