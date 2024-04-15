<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $table = 'mensajes';

    protected $fillable = [
        'id_usuario_envio', 'mensaje', 'fecha', 'fecha_eliminacion', 'FK_id_chat'
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'FK_id_chat', 'id_chat');
    }

    public function usuarioEnvio()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_envio');
    }
}
