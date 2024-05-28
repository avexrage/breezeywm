<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Asuransi;
use App\Models\DataPeserta;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


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
    public function create(Request $request)
    {
        $programId = $request->id;
            $program = Program::find($programId);
            if (!$program) {
                abort(404); // Program tidak ditemukan
            } // defaultProgram adalah nilai default
        return view('layouts.create', compact('program'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
   
        if ($request->program_id == '111') {
            return redirect('/daftar')->with('success', 'Data Peserta Berhasil Disimpan');
        } else if ($request->program_id == '21') {
            return redirect('/daftar/grha')->with('success', 'Data Peserta Berhasil Disimpan');
        }
    
    }

    public function showDaftar (Request $request){

        return view('layouts.daftar');
    }

    public function daftar( Request $request){

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
            'programs.required' => 'Pilih program yang ada.'
        ]); 

        $form1Data = $request->session()->get('form1_data');

        if ($form1Data) {
            //Simpan data ke tabel data_peserta
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
            //Simpan data ke tabel asuransi
        if (!empty($form1Data['asuransi']) && !empty($form1Data['noasuransi'])) {
            $dataAsuransi = new Asuransi([
                'nama_asuransi' => $form1Data['asuransi'],
                'no_asuransi' => $form1Data['noasuransi']
            ]);
       
            $dataPeserta->save(); // Save data_peserta record
            $dataAsuransi->data_peserta_id = $dataPeserta->id; // Assign data_peserta_id to dataAsuransi
            $dataAsuransi->save(); // Update dataAsuransi with data_peserta_id
        }
            // Simpan data ke tabel pendaftaran
        $pendaftaran = new Pendaftaran([
            'check_in' => $validatedData['tanggal_mulai'],
            'check_out' => $validatedData['tanggal_selesai'],
            'metode_pembayaran' => $validatedData['metodePembayaran'],
            'data_peserta_id' => $dataPeserta->id,
        ]);
    
        $pendaftaran->save(); // Simpan data pendaftaran

        foreach ($validatedData['programs'] as $date => $programId) {
            // Ambil data program berdasarkan ID
            $program = Program::findOrFail($programId);
        
            // Simpan relasi many-to-many antara pendaftaran dan program
            $pendaftaran->program()->attach($programId, [
                'tanggal' => $date,
                'tipe' => $program->tipe, // Tambahkan 'tipe' dari data program
                'harga' => $program->harga, // Tambahkan 'harga' dari data program
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
            
            $request->session()->forget('form1_data'); // Clear session data

            return redirect()->route('bayarday')->with('success', 'Pendaftaran berhasil disimpan.');
            }
        }

        public function showDaftar2 (Request $request){

            return view('layouts.daftar2');
        }
        
        public function daftar2(){
            
        }

        public function cancelRegistration(Request $request)
        {
            // Clear session data
            $request->session()->forget('form1_data');

            // Redirect to the first form or any other page
            return redirect()->route('daftar')->with('status', 'Pendaftaran Dibatalkan');
        }
}