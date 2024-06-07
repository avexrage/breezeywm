<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewRegistrationNotification extends Notification
{
    use Queueable;

    protected $dataPeserta;
    protected $program;

    public function __construct($dataPeserta, $program)
    {
        $this->dataPeserta = $dataPeserta;
        $this->program = $program;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Pendaftaran baru telah dibuat.')
                    ->line('Nama Peserta: ' . $this->dataPeserta->nama_lengkap_peserta)
                    ->line('Program: ' . $this->program->nama_program)
                    ->action('Lihat Detail', url('/'))
                    ->line('Terima kasih telah menggunakan aplikasi kami!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Pendaftaran baru telah dibuat oleh ' . $this->dataPeserta->nama_lengkap_peserta . ' untuk program ' . $this->program->nama_program,
            'data_peserta_id' => $this->dataPeserta->id,
            'program_id' => $this->program->id_program
        ];
    }
}
