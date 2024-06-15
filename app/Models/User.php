<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'user';
    protected $fillable = [
        'ktp',
        'email',
        'password',
        'nama',
        'no_hp',
        'alamat',
        'pekerjaan',
        'role',
        'email_verified_at',
        'remember_token'
    ];
    protected $attributes = [
        'role' => 'user',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function peserta(){
        return $this->hasMany(Peserta::class);
    }

    public function pendaftaran(){
        return $this->hasMany(Pendaftaran::class);
    }

    public function sendEmailVerificationNotification(){
    $this->notify(new CustomVerifyEmail);
    }

}