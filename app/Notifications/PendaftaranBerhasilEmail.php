<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PendaftaranBerhasilEmail extends Notification
{
    use Queueable;

    protected $pendaftaran;
    protected $peserta;

    public function __construct($pendaftaran, $peserta)
    {
        $this->pendaftaran = $pendaftaran;
        $this->peserta = $peserta;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable){
        $programDetails = $this->pendaftaran->program->map(function($program) {
            return [
                'tanggal' => \Carbon\Carbon::parse($program->pivot->tanggal)->format('d-m-Y'),
                'tipe' => $program->pivot->tipe,
                'harga' => number_format($program->pivot->harga, 0, ',', '.')
            ];
        });

        $message = (new MailMessage)
            ->line('Pendaftaran Anda telah berhasil dilakukan.')
            ->line('Nama Peserta: ' . $this->peserta->nama_lengkap_peserta)
            ->line('Program: ' . $this->pendaftaran->program->first()->nama_program)
            ->line('Check-in: ' . \Carbon\Carbon::parse($this->pendaftaran->check_in)->format('d-m-Y'))
            ->line('Check-out: ' . \Carbon\Carbon::parse($this->pendaftaran->check_out)->format('d-m-Y'))
            ->line('Rincian Program:')
            ->line('| Tanggal       | Tipe       | Harga       |')
            ->line('| ------------- | ---------- | ----------- |');

        foreach ($programDetails as $detail) {
            $message->line('| ' . $detail['tanggal'] . ' | ' . $detail['tipe'] . ' | ' . $detail['harga'] . ' |');
        }

        $message->line('Total Harga: ' . number_format($this->pendaftaran->transaksi->total_harga, 0, ',', '.'))
            ->action('Lihat Detail', url('/tagihan-pembayaran'))
            ->line('Terima kasih telah menggunakan layanan kami!');

        return $message;
    }


}
