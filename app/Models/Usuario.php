<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuario';

    protected $fillable = [
        'nombreUsuario', 'password', 'telefono', 'email', 'email_verified_at',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function admin()
    {
        return $this->hasOne(Admin::class, 'usuario_id');
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'usuario_id');
    }
}
