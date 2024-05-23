<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suscripcion extends Model
{
    use HasFactory;

    protected $table = 'suscripcion';

    protected $fillable = [
        'cliente_id', 'anuncio_id', 'fechaIni', 'fechaFin', 'activa', 'precio',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function anuncio()
    {
        return $this->belongsTo(Anuncio::class, 'anuncio_id');
    }
}
