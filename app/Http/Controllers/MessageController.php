<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::all(); // Obtener todos los mensajes
        return view('chat.index', compact('messages'));
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'content' => 'required|string|max:500',
            'user_id' => 'required|exists:users,id', // Asegúrate de que el usuario exista
            'chat_id' => 'required|exists:chats,id', // Asegúrate de que el chat exista
        ]);

        // Crear un nuevo mensaje
        $message = new Message();
        $message->content = $request->content;
        $message->user_id = $request->user_id;
        $message->chat_id = $request->chat_id;
        $message->save();

        return redirect()->back()->with('success', 'Mensaje enviado correctamente.');
    }

    public function update(Request $request, $id_mensaje)
    {
        // Validar la solicitud
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        // Buscar el mensaje por ID
        $message = Message::find($id_mensaje);
        if (!$message) {
            return redirect()->back()->with('error', 'Mensaje no encontrado.');
        }

        // Actualizar el contenido del mensaje
        $message->content = $request->content;
        $message->save();

        return redirect()->back()->with('success', 'Mensaje actualizado correctamente.');
    }

    public function destroy($id_mensaje)
    {
        // Buscar el mensaje por ID
        $message = Message::find($id_mensaje);
        if (!$message) {
            return redirect()->back()->with('error', 'Mensaje no encontrado.');
        }

        // Eliminar el mensaje
        $message->delete();

        return redirect()->back()->with('success', 'Mensaje eliminado correctamente.');
    }

    public function show($id_chat, $mensaje, $id_usuario)
    {
        $message = Message::where('chat_id', $id_chat)
                      ->where('user_id', $id_usuario)
                      ->where('content', $mensaje)
                      ->first();

        // Verificar si el mensaje fue encontrado
        if ($message) {
            // Aquí puedes retornar una vista o JSON con el mensaje encontrado.
            return response()->json(['message' => $message]);
        } else {
            // Si el mensaje no se encuentra, puedes retornar un mensaje de error.
            return response()->json(['error' => 'Mensaje no encontrado.']);
        }
    }
}
