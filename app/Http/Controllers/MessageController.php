<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/*use App\Models\Message;*/
use App\Models\Mensaje;
/*php artisan make:model Mensaje

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
            'username' => 'required|exists:users,id', // Asegúrate de que el usuario exista
            'chat_id' => 'required|exists:chats,id', // Asegúrate de que el chat exista
        ]);

        // Crear un nuevo mensaje
        $message = new Message();
        $message->content = $request->content;
        $message->username = $request->username;
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

    public function show($id_chat, $mensaje, $username)
    {
        $message = Message::where('chat_id', $id_chat)
                      ->where('user_id', $username)
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
*/

class MessageController extends Controller
{
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'username_envio' => 'required',
            'mensaje' => 'required',
            'FK_id_chat' => 'required',
        ]);

        // Crear un nuevo mensaje en la base de datos
        Mensaje::create([
            'username_envio' => $request->username_envio,
            'mensaje' => $request->mensaje,
            'FK_id_chat' => $request->FK_id_chat,
        ]);

        // Devolver una respuesta
        return response()->json(['message' => 'Mensaje enviado correctamente'], 200);
    }
}
