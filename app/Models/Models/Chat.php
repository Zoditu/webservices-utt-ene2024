<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chat';

    protected $fillable = [
        'id_chat', 'FK_username'
    ];

    public $incrementing = false;

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'FK_username', 'username');
    }

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class, 'FK_id_chat', 'id_chat');
    }
}
