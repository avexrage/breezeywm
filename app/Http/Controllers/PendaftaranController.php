<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Video;
use App\Models\Program;
use App\Models\Asuransi;
use App\Models\Transaksi;
use App\Models\DataPeserta;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Models\RiwayatPendaftaran;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Notifications\NewRegistrationNotification;


class PendaftaranController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
       //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        $programId = $request->id;
            $program = Program::find($programId);
            if (!$program) {
                abort(404); // Program tidak ditemukan
            } // defaultProgram adalah nilai default
            
            // Add this line to retrieve the historical registrations
            $riwayatPendaftarans = RiwayatPendaftaran::where('user_id', Auth::id())->get();
        return view('layouts.create', compact('program', 'riwayatPendaftarans'));
    }

    public function showForm($program_id){
        $program = Program::find($program_id);
        if (!$program) {
            abort(404, 'Program not found.');
        }
        $riwayatPendaftarans = RiwayatPendaftaran::where('user_id', Auth::id())->get();
    
        return view('layouts.create', compact('program', 'riwayatPendaftarans'));
    }

     public function storeRiwayatPendaftaran($program_id, $riwayat_id){
         $riwayatPendaftaran = RiwayatPendaftaran::where('id', $riwayat_id)
                                                  ->where('user_id', Auth::id())
                                                  ->first();
     
         if ($riwayatPendaftaran) {
             session([
                 'form1_data' => [
                     'datalama' => true, // Menandai penggunaan data lama
                     'riwayat_pendaftaran_id' => $riwayatPendaftaran->id, // Menyimpan ID riwayat pendaftaran
                     'data_peserta_id' => $riwayatPendaftaran->data_peserta_id,
                     'program_id' => $program_id,
                     'ktp' => $riwayatPendaftaran->ktp,
                     'nama' => $riwayatPendaftaran->nama_lengkap_peserta,
                     'alamat' => $riwayatPendaftaran->alamat,
                     'tlahir' => $riwayatPendaftaran->tempat_lahir,
                     'tgllhr' => $riwayatPendaftaran->tanggal_lahir,
                     'kelamin' => $riwayatPendaftaran->jenis_kelamin,
                     'agama' => $riwayatPendaftaran->agama,
                     'statusNikah' => $riwayatPendaftaran->statusnikah,
                     'pekerjaan' => $riwayatPendaftaran->pekerjaan,
                     'penyakit' => $riwayatPendaftaran->riwayat_penyakit,
                     'asuransi' => $riwayatPendaftaran->nama_asuransi,
                     'noasuransi' => $riwayatPendaftaran->no_asuransi,
                     'hobi' => $riwayatPendaftaran->hobi,
                     'keahlian' => $riwayatPendaftaran->keahlian,
                     'bahasa' => $riwayatPendaftaran->bahasa,
                 ]
             ]);
     
             if ($program_id == '111') {
                 return redirect()->route('showdaftar')->with('success', 'Data Peserta Berhasil Disimpan');
             } elseif ($program_id == '21') {
                 return redirect()->route('showdaftar2')->with('success', 'Data Peserta Berhasil Disimpan');
             } 
         } else {
             return redirect()->back()->with('error', 'Data riwayat pendaftaran tidak ditemukan.');
         }
    }
     
    public function store(Request $request){

        Session::flash('ktp', $request->ktp);
        Session::flash('nama_lengkap_peserta', $request->nama);
        Session::flash('alamat', $request->alamat);
        Session::flash('tempat_lahir', $request->tlahir);
        Session::flash('tanggal_lahir', $request->tgllhr);
        Session::flash('jenis_kelamin', $request->kelamin);
        Session::flash('agama', $request->agama);
        Session::flash('statusnikah', $request->statusNikah);
        Session::flash('pekerjaan', $request->pekerjaan);
        Session::flash('riwayat_penyakit', $request->penyakit);
        Session::flash('nama_asuransi', $request->asuransi);
        Session::flash('no_asuransi', $request->noasuransi);
        Session::flash('hobi', $request->hobi);
        Session::flash('keahlian', $request->keahlian);
        Session::flash('bahasa', $request->bahasa);

        $validatedData = $request->validate([
            'program_id' => 'required|exists:program,id_program',
            'nama' => 'required|string|max:50',
            'ktp' => 'required|string|size:16',
            'alamat' => 'required|string',
            'tlahir' => 'required|string',
            'tgllhr'  => 'required|date',
            'kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Khonghucu',
            'statusNikah' => 'required|in:Belum Kawin,Kawin,Cerai Mati,Cerai Hidup',
            'pekerjaan' => 'required|string|max:30',
            'penyakit' => 'required|string|max:50',
            'asuransi' => 'required|string|max:50',
            'noasuransi' => 'required|string|max:16',
            'hobi' => 'required|string|max:30',
            'keahlian' => 'required|string|max:30',
            'bahasa' => 'required|string|max:30',
        ], [
            'ktp.required' => 'Nomor KTP wajib diisi.',
            'ktp.size' => 'Nomor KTP harus tepat 16 digit.',
            'nama.required' => 'Nama Lengkap wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'tlahir.required' => 'Tempat Lahir wajib diisi.',
            'tgllhr.required' => 'Tanggal Lahir wajib diisi.',
            'kelamin.required' => 'Jenis Kelamin wajib diisi.',
            'agama.required' => 'Agama wajib diisi.',
            'statusNikah.required' => 'Status Nikah wajib diisi.',
            'pekerjaan.required' => 'Pekerjaan wajib diisi.',
            'penyakit.required' => 'Riwayat Penyakit wajib diisi.',
            'asuransi.required' => 'Nama Asuransi wajib diisi. Bila tidak ada tulis Tidak Ada',
            'noasuransi.required' => 'No Asuransi wajib diisi. Bila tidak ada tulis Tidak Ada',
            'hobi.required' => 'Hobi wajib diisi.',
            'keahlian.required' => 'Keahlian wajib diisi.',
            'bahasa.required' => 'Bahasa Sehari-hari wajib diisi.',
        ]);

        $request->session()->put('form1_data', $validatedData);

        // Redirect sesuai dengan program_id
        if ($request->program_id == '111') {
            return redirect()->route('showdaftar')->with('success', 'Data Peserta Berhasil Disimpan');
        } else if ($request->program_id == '21') {
            return redirect()->route('showdaftar2')->with('success', 'Data Peserta Berhasil Disimpan');
        }
    }

    public function showDaftar (){

        return view('layouts.daftar');
    }

    public function daftar(Request $request){
    $validatedData = $request->validate([
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date',
        'metodePembayaran' => 'required|in:Tunai,Transfer BRI',
        'programs' => 'required|array',
        'programs.*' => 'required|string|exists:program,id_program'
    ],[
        'tanggal_mulai.required'=> 'Tanggal mulai program wajib diisi',
        'tanggal_selesai.required'=> 'Tanggal selesai program wajib diisi',
        'metodePembayaran.required'=> 'Metode pembayaran wajib diisi',
        'programs.required' => 'Pilih Tanggal Mulai dan Selesai Lagi.'
    ]); 

    $form1Data = $request->session()->get('form1_data');

    if ($form1Data) {  
        if (isset($form1Data['datalama']) && $form1Data['datalama']) {
            // Menggunakan data peserta lama
            $peserta_id = $form1Data['data_peserta_id'];
            $riwayat_id = $form1Data['riwayat_pendaftaran_id'];
        } else {
            // Simpan data ke tabel data_peserta
            $dataPeserta = DataPeserta::create([
                'program_id' => $form1Data['program_id'],
                'ktp' => $form1Data['ktp'],
                'nama_lengkap_peserta' => $form1Data['nama'],
                'alamat' => $form1Data['alamat'],
                'tempat_lahir' => $form1Data['tlahir'],
                'tanggal_lahir' => $form1Data['tgllhr'],
                'jenis_kelamin' => $form1Data['kelamin'],
                'agama' => $form1Data['agama'],
                'statusnikah' => $form1Data['statusNikah'],
                'pekerjaan' => $form1Data['pekerjaan'],
                'riwayat_penyakit' => $form1Data['penyakit'],
                'hobi' => $form1Data['hobi'],
                'keahlian' => $form1Data['keahlian'],
                'bahasa' => $form1Data['bahasa'],
                'user_id' => Auth::id() // Mengaitkan langsung pada saat pembuatan
            ]);
            $peserta_id = $dataPeserta->id;

            // Simpan data ke tabel asuransi
            if (!empty($form1Data['asuransi']) && !empty($form1Data['noasuransi'])) {
                $dataAsuransi = new Asuransi([
                    'nama_asuransi' => $form1Data['asuransi'],
                    'no_asuransi' => $form1Data['noasuransi']
                ]);
        
                $dataPeserta->save(); // Save data_peserta record
                $dataAsuransi->data_peserta_id = $dataPeserta->id; // Assign data_peserta_id to dataAsuransi
                $dataAsuransi->save(); // Update dataAsuransi with data_peserta_id
            }

            // Simpan data ke tabel riwayat_pendaftaran
            $riwayatPendaftaran = new RiwayatPendaftaran([
                'user_id' => Auth::id(),
                'nama_lengkap_peserta' => $form1Data['nama'],
                'ktp' => $form1Data['ktp'],
                'alamat' => $form1Data['alamat'],
                'tempat_lahir' => $form1Data['tlahir'],
                'tanggal_lahir' => $form1Data['tgllhr'],
                'jenis_kelamin' => $form1Data['kelamin'],
                'agama' => $form1Data['agama'],
                'statusnikah' => $form1Data['statusNikah'],
                'pekerjaan' => $form1Data['pekerjaan'],
                'riwayat_penyakit' => $form1Data['penyakit'],
                'nama_asuransi' => $form1Data['asuransi'],
                'no_asuransi' => $form1Data['noasuransi'],
                'hobi' => $form1Data['hobi'],
                'keahlian' => $form1Data['keahlian'],
                'bahasa' => $form1Data['bahasa'],
                'tanggal_riwayat' => now(),
                'data_peserta_id' => $peserta_id,
            ]);
            $riwayatPendaftaran->save();
            $riwayat_id = $riwayatPendaftaran->id; // Ambil ID riwayat yang baru dibuat
        }

        // Simpan data ke tabel pendaftaran
        $pendaftaran = new Pendaftaran([
            'check_in' => $validatedData['tanggal_mulai'],
            'check_out' => $validatedData['tanggal_selesai'],
            'metode_pembayaran' => $validatedData['metodePembayaran'],
            'data_peserta_id' => $peserta_id,     
            'riwayat_pendaftaran_id' => $riwayat_id,     
        ]);
        $pendaftaran->save(); // Simpan data pendaftaran

        foreach ($validatedData['programs'] as $date => $programId) {
            // Ambil data program berdasarkan ID
            $program = Program::findOrFail($programId);

            // Simpan relasi many-to-many antara pendaftaran dan program
            $pendaftaran->program()->attach($programId, [
                'tanggal' => $date,
                'tipe' => $program->tipe, 
                'harga' => $program->harga, 
            ]);
        }
        
        // Buat entri Transaksi
        $totalPrice = $request->input('summaryTotalPrice');
        if (!isset($totalPrice)) {
            return back()->withErrors(['summaryTotalPrice' => 'Total harga tidak ditemukan']);
        }
          
        $transaksi = Transaksi::create([
            'total_harga' => $totalPrice,
            'pendaftaran_id' => $pendaftaran->id
        ]);
        
        $transaksi->pendaftaran_id = $pendaftaran->id;
        $transaksi->save(); // Simpan entri transaksi    

        // $request->session()->forget('form1_data'); // Clear session data

            return redirect()->route('bayar')->with('success', 'Pendaftaran berhasil disimpan.');
        } else {
            return back()->withErrors(['form1_data' => 'Data pendaftaran tidak ditemukan.']);
        }
    }


    public function showDaftar2 (){

        return view('layouts.daftar2');
    }

    public function daftar2(Request $request) {
        $validatedData = $request->validate([
            'program' => 'required|string|in:21,22',
            'durasi' => 'required',
            'video' => 'required|file|mimes:mp4,mov,avi,wmv|max:20480', // Batas maksimum 20MB untuk video
        ],[
            'program.required' => 'Pilih Tipe Rumah yang tersedia.',
            'durasi.required' => 'Pilih Lama Mengikuti Program.',
            'video.required' => 'Bukti Video Kemandirian Lansia Wajib Diisi',
            'video.max' => 'Besar maksimal ukuran video 20MB',
            'video.mimes' => 'Tipe video yang diterima adalah mp4, mov, avi, wmv'
        ]); 
    
        // Dapatkan data peserta dari session
        $form1Data = $request->session()->get('form1_data');
    
        if ($form1Data) {
        // Simpan data ke tabel data_peserta
        $dataPeserta = DataPeserta::create([
            'program_id' => $form1Data['program_id'],
            'ktp' => $form1Data['ktp'],
            'nama_lengkap_peserta' => $form1Data['nama'],
            'alamat' => $form1Data['alamat'],
            'tempat_lahir' => $form1Data['tlahir'],
            'tanggal_lahir' => $form1Data['tgllhr'],
            'jenis_kelamin' => $form1Data['kelamin'],
            'agama' => $form1Data['agama'],
            'statusnikah' => $form1Data['statusNikah'],
            'pekerjaan' => $form1Data['pekerjaan'],
            'riwayat_penyakit' => $form1Data['penyakit'],
            'hobi' => $form1Data['hobi'],
            'keahlian' => $form1Data['keahlian'],
            'bahasa' => $form1Data['bahasa'],
            'user_id' => Auth::id() // Mengaitkan langsung pada saat pembuatan
        ]);

        // Simpan data ke tabel asuransi
        if (!empty($form1Data['asuransi']) && !empty($form1Data['noasuransi'])) {
            $dataAsuransi = new Asuransi([
                'nama_asuransi' => $form1Data['asuransi'],
                'no_asuransi' => $form1Data['noasuransi']
            ]);
        
            $dataPeserta->save(); // Save data_peserta record
            $dataAsuransi->data_peserta_id = $dataPeserta->id; // Assign data_peserta_id to dataAsuransi
            $dataAsuransi->save(); // Update dataAsuransi with data_peserta_id
        }
        
        // Simpan data pendaftaran
        $pendaftaran = new Pendaftaran([
            'check_in' => null,
            'check_out' => null,
            'metode_pembayaran' => null,
            'data_peserta_id' => $dataPeserta->id,
        ]);
        $pendaftaran->save(); 

        // Ambil data program berdasarkan ID
        $program = Program::findOrFail($validatedData['program']);

        // Simpan relasi many-to-many antara pendaftaran dan program
        $pendaftaran->program()->attach($validatedData['program'], [
            'durasi' => $validatedData['durasi'],
            'tipe' => $program->tipe, 
            'harga' => $program->harga, 
        ]);

        // Hitung total harga
        $totalHarga = $validatedData['durasi'] * $program->harga;

        $transaksi = new Transaksi([
            'total_harga' => $totalHarga,
            'pendaftaran_id' => $pendaftaran->id // Assuming you have a foreign key relationship
        ]);
        $transaksi->save();
        
        // Simpan video ke dalam penyimpanan yang sesuai (local, S3, dll.)
        $videoPath = $request->file('video')->store('videos', 'public');
        // Buat instansiasi baru dari model Video dan simpan informasinya
        $video = new Video([
            'nama_file' => basename($videoPath), // Nama file saja
            'tanggal_upload' => now(), // Tanggal upload saat ini
            'ukuran_file' => $request->file('video')->getSize(), // Ukuran file dalam byte
            'data_peserta_id' => $dataPeserta->id, // Mengaitkan video dengan data peserta
        ]);
    
        // Simpan video ke database
        $video->save();
    
        // Hapus data peserta dari session
        $request->session()->forget('form1_data');
    
        // Kirim data video ke view
        return redirect()->route('riwayat')->with(['success' => 'Pendaftaran Berhasil Disimpan, Tunggu Admin Memverifikasi Video Kemandirian', 'video' => $video]);
        }
    
        return redirect()->back()->withErrors(['error' => 'Data peserta tidak ditemukan di sesi.']);
    }
    
    public function batalkanPendaftaran($id)
    {
        $daftar = Pendaftaran::find($id);
        if ($daftar) {
            $daftar->status_pendaftaran = 'Dibatalkan';
            $daftar->save();
        }
        return redirect()->route('riwayat');
    }
    
    
}    