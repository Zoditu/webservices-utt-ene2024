<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuario';

    protected $primaryKey = 'username';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'username', 'name', 'lastName', 'email', 'phone', 'sex', 'birth', 'password', 'image'
    ];

    public function chats()
    {
        return $this->hasMany(Chat::class, 'FK_username', 'username');
    }

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class, 'id_usuario_envio');
    }
}
