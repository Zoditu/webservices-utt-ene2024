<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        // Lógica para obtener todos los mensajes
    }

    public function store(Request $request)
    {
        // Lógica para almacenar un nuevo mensaje
    }

    public function update(Request $request, $id_mensaje)
    {
        // Lógica para actualizar un mensaje existente
    }

    public function destroy($id_mensaje)
    {
        // Lógica para eliminar un mensaje
    }

    public function show($id_chat, $mensaje, $id_usuario)
    {
        // Lógica para mostrar un nuevo mensaje en un chat de un usuario
    }
}
