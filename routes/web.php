<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use Illuminate\Database\Eloquent\Model;
use App\Models\Mensaje as MensajeModel;
use App\Models\Mensaje;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
/*use App\Http\Controllers\MessageController;*/
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ChatController;


/*VISTA*/
/*Route::get('/chat', 'ChatController@index');*/
/*Route::get('/mensaje', [MessageController::class, 'store']);
Route::post('/mensajes', 'MessageController@store');
Route::post('/mensajes', [MessageController::class, 'store']);
Route::post('/mensajes', 'App\Http\Controllers\MessageController@store');

Route::post('/mensajes', 'MessageController@store')->name('mensajes');*


Route::post('/mensajes', 'MessageController@store');*/
/*Route::get('/menu-contactos', 'MessageController@showContactMenu')->name('menu_contactos');
Route::post('/agregar-contacto', 'MessageController@addContact')->name('agregar_contacto');*/

/*Route::get('/menu-contactos', 'ContactoController@index')->name('menu_contactos');
Route::post('/agregar-contacto', 'ContactoController@store')->name('agregar_contacto');*/



Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');

Route::get('/profile', function(Request $req) { 
    //create table Usuario(username varchar(20) primary key, name varchar(20), lastName varchar(50), email tinytext, phone varchar(12), sex varchar(20), birth date, password varchar(16), image mediumtext);
    //alter table usuario add column image mediumtext;
    $user = $req->get("user");
    $usuario = null;
    if($user) {
        $usuario = 
            DB::select("select username, name, lastName, email, phone, sex, birth, image from usuario where username='".$user."'");

        return !$usuario ? new Response(view("error", ["code" => 404, "error" => "No se ha encontrado el usuario [".$user."]"]), 404) : view("user", (array)$usuario[0]);
    } else {
        return new Response(view("error", [
            "code" => 400, "error" => "Debe especificar el usuario como: ?user=USER"
        ]), 400);
    }
    /*$entorno = [
        'DB_CONNECTION' => env("DB_CONNECTION"),
        'DATABASE_URL' => env("DATABASE_URL")
    ];
    return $entorno;*/
});

Route::post('/register/{username}', function(Request $request, $username) {

    /*$query = $request->all(); //Trae todo, tanto query como body
    $body = $request->getContent(); //body como contenido de texto
    $response = new Response(["username" => "Quiero registrar a: " . $username,
        "params" => $query,
        "body" => json_decode($body) //Parsear el contenido del texto
    ]);*/

    $username = strtolower($username); //Estandarizar el username a lowercase
    preg_match("/[a-zñ0-9\-_]{4,}/", $username, $matches);
    if(count($matches) != 1) {
        return new Response(["error" => "El usuario debe ser solo con caracteres del tipo letras, números, - y _ y mínimo 4 caracteres (" . $username . ")"], 400);
    } else if(strlen($matches[0]) != strlen($username)) {
        return new Response(["error" => "El usuario debe ser solo con caracteres del tipo letras, números, - y _ y mínimo 4 caracteres (" . $username . ")"], 400);
    }

    $count = DB::selectOne("select count(username) from usuario where username = '" . $username . "'");

    $keys = array_keys((array)$count);
    $count = (array)$count;

    if($count[$keys[0]] != 0) {
        //Ya existe este usuario... Duplicado
        return new Response([
            "error" => "El usuario que escogiste ya está registrado"
        ], 409);
    }
    
    $request->validate([
        "email" => "required|email|max:255",
        "name" => "required|max:20",
        "password" => "required|min:8|max:16",
        "lastName" => "max:50",
        "birth" => "date",
        "phone" => "min:10|max:12",
        "sex" => "max:20"
    ]);

    $body = $request->all();
    $body["username"] = $username;
    //$response = ["resultado" => $count];
    //$response->withCookie(cookie('utt', 'este valor', 100000));

    $objectBody = (object)$body;
    $cleanData = [
        "username" => $username,
        "email" => $body["email"],
        "password" => $body["password"],
        "name" => $body["name"],
        "lastName" => property_exists($objectBody, "lastName") ? $body["lastName"] : "",
        "phone" => property_exists($objectBody, "phone") ? $body["phone"] : "",
        "sex" => property_exists($objectBody, "sex") ? $body["sex"] : "",
        "birth" => property_exists($objectBody, "birth") ? $body["birth"] : null
    ];
    
    $insert = DB::table("usuario")->insert($cleanData);

    return [
        "ok" => $insert == 1 ? true : false
    ];
});
/*----------------------------MENSAJES-------------------------------------------*/
// Ruta para almacenar un mensaje en la base de datos
Route::post('/mensajes', function (Request $request) {
    // Validar los datos recibidos
    $request->validate([
        'username_envio' => 'required',
        'mensaje' => 'required',
        'FK_id_chat' => 'required',
    ]);

    // Obtener los datos del request
    $usernameEnvio = $request->input('username_envio');
    $mensaje = $request->input('mensaje'); // Aquí estaba 'mensajes', debe ser 'mensaje'
    $idChat = $request->input('FK_id_chat');

    // Insertar el mensaje en la base de datos
    DB::table('mensajes')->insert([
        'username_envio' => $usernameEnvio,
        'mensaje' => $mensaje, // Aquí estaba 'mensajes', debe ser 'mensaje'
        'FK_id_chat' => $idChat,
    ]);

    // Retornar una respuesta de éxito
    return response()->json(['mensaje' => 'Mensaje almacenado correctamente'], 200);
});


// Ruta para leer mensajes
Route::get('/mensajes', function () {
    // Lógica para leer mensajes
});


/*----------------------ENVIAR MENSAJES--------------------------------*/
// Ruta para enviar mensajes
Route::post('/mensajes', function (Request $request) {
    // Validar los datos del mensaje
    $request->validate([
        'mensaje' => 'required|string',
        'username_envio' => 'required|string',
        'FK_id_chat' => 'required|integer',
        // Puedes agregar más reglas de validación según tus necesidades
    ]);

    // Crear un nuevo mensaje con los datos recibidos
    $mensaje = new MensajeModel();
    $mensaje->mensaje = $request->input('mensaje');
    $mensaje->username_envio = $request->input('username_envio');
    $mensaje->FK_id_chat = $request->input('FK_id_chat');
    // Puedes asignar más atributos al mensaje si es necesario

    // Guardar el mensaje en la base de datos
    $mensaje->save();

    // Devolver una respuesta de éxito
    return response()->json(['mensaje' => 'Mensaje agregado correctamente'], 201);
});

/*----------------------EDITAR MENSAJES--------------------------------*/
// Define la ruta que usa el modelo Mensaje para editar un mensaje por id_mensaje
Route::put('/mensajes/{id_mensaje}', function (Request $request, $id_mensaje) {
    // Instancia el modelo Mensaje
    $mensaje = new Mensaje();

    // Especifica el nombre de la clave primaria
    $mensaje->setKeyName('id_mensaje');

    // Validar los datos del mensaje a editar
    $request->validate([
        'mensaje' => 'required|string',
        'username_envio' => 'required|string',
        'FK_id_chat' => 'required|integer',
        // Puedes agregar más reglas de validación según tus necesidades
    ]);

    // Buscar el mensaje por id_mensaje
    $mensaje = Mensaje::find($id_mensaje);

    // Verificar si se encontró el mensaje
    if ($mensaje) {
        // Actualizar los campos del mensaje con los datos recibidos
        $mensaje->mensaje = $request->input('mensaje');
        $mensaje->username_envio = $request->input('username_envio');
        $mensaje->FK_id_chat = $request->input('FK_id_chat');
        // Puedes asignar más atributos al mensaje si es necesario

        // Guardar los cambios en la base de datos
        $mensaje->save();

        // Devolver una respuesta de éxito
        return response()->json(['mensaje' => 'Mensaje actualizado correctamente'], 200);
    } else {
        // Si el mensaje no se encuentra, devolver un mensaje de error
        return response()->json(['mensaje' => 'Mensaje no encontrado'], 404);
    }
});



/*----------------------ELIMINAR MENSAJES--------------------------------*/

// Eliminar mensaje
/*Route::delete('/mensajes/{id}', function ($id) {
    // Convertir el id a entero
    $id = intval($id);

    // Eliminar el mensaje por su id_mensaje
    $deleted = DB::table('mensajes')->where('id_mensaje', $id)->delete();

    if ($deleted) {
        return response()->json(['mensaje' => 'Mensaje eliminado correctamente'], 200);
    } else {
        return response()->json(['mensaje' => 'Mensaje no encontrado'], 404);
    }
});*/

Route::delete('/mensajes/{id}', function ($id) {
    // Convertir el id a entero
    $id = intval($id);

    // Eliminar el mensaje por su id
    $deleted = DB::table('mensajes')->where('id', $id)->delete();

    if ($deleted) {
        return response()->json(['mensaje' => 'Mensaje eliminado correctamente'], 200);
    } else {
        return response()->json(['mensaje' => 'Mensaje no encontrado'], 404);
    }
});

/*----------------------VER MENSAJES--------------------------------*/

// VER mensajes
Route::get('/mensajes/{id}', function ($id) {
    // Convertir el id a entero
    $id = intval($id);

    // Consultar la base de datos para obtener el mensaje por su ID
    $mensaje = DB::table('mensajes')->where('id', $id)->first();

    if ($mensaje) {
        // Si se encuentra el mensaje, devolverlo como JSON
        return response()->json(['mensaje' => $mensaje], 200);
    } else {
        // Si no se encuentra el mensaje, devolver un mensaje de error
        return response()->json(['mensaje' => 'Mensaje no encontrado'], 404);
    }
});

// Leer nuevo mensaje en un chat de un usuario
Route::get('/chats/{id_chat}/mensajes/{mensaje}/{username}', function ($id_chat, $mensaje, $username) {
    // Lógica para leer nuevos mensajes en un chat de un usuario
});

// Almacenar un nuevo mensaje en un chat de un usuario
Route::post('/chats/{id_chat}/mensajes/{mensaje}/usuarios/{username}', function ($id_chat, $mensaje, $username) {
    // Lógica para almacenar nuevos mensajes en un chat de un usuario
});

// Actualizar un mensaje en un chat de un usuario
Route::put('/chats/{id_chat}/mensajes/{mensaje}/{username}', function ($id_chat, $mensaje, $username) {
    // Lógica para actualizar mensajes en un chat de un usuario
});

// Eliminar un mensaje en un chat de un usuario
Route::delete('/chats/{id_chat}/mensajes/{mensaje}/{username}', function ($id_chat, $mensaje, $username) {
    // Lógica para eliminar mensajes en un chat de un usuario
});


//MENSAJE
// Leer mensaje
//Route::get('/mensajes', 'MessageController@index');

// Enviar mensaje
//Route::post('/mensajes', 'MessageController@store');
/*Route::post('/store', [MessageController::class,'store'])->name('store');*/

// Editar mensaje
//Route::put('/mensajes/{id_mensaje}', 'MessageController@update');

// Eliminar mensaje
//Route::delete('/mensajes/{id_mensaje}', 'MessageController@destroy');

// Leer nuevo mensaje en un chat de un usuario
//Route::get('/chats/{id_chat}/mensajes/{mensaje}/{username}', 'MessageController@show');

// Almacenar un nuevo mensaje en un chat de un usuario
//Route::post('/chats/{id_chat}/mensajes/{mensaje}/usuarios/{username}', 'MessageController@store');

// Actualizar un mensaje en un chat de un usuario
//Route::put('/chats/{id_chat}/mensajes/{mensaje}/{username}', 'MessageController@update');

// Eliminar un mensaje en un chat de un usuario
//Route::delete('/chats/{id_chat}/mensajes/{mensaje}/{username}', 'MessageController@destroy');

/*Route::get('/chat', 'ChatController@index');

// Rutas relacionadas con los mensajes
Route::get('/mensajes', 'MessageController@index'); // Mostrar todos los mensajes
Route::post('/mensajes', 'MessageController@store'); // Crear un nuevo mensaje
Route::put('/mensajes/{id_mensaje}', 'MessageController@update'); // Editar un mensaje
Route::delete('/mensajes/{id_mensaje}', 'MessageController@destroy'); // Eliminar un mensaje

// Rutas adicionales relacionadas con los chats y los usuarios
Route::get('/chats/{id_chat}/mensajes/{mensaje}/{username}', 'MessageController@show'); // Leer nuevo mensaje en un chat de un usuario
Route::post('/chats/{id_chat}/mensajes/{mensaje}/usuarios/{username}', 'MessageController@store'); // Almacenar un nuevo mensaje en un chat de un usuario
Route::put('/chats/{id_chat}/mensajes/{mensaje}/{username}', 'MessageController@update'); // Actualizar un mensaje en un chat de un usuario
Route::delete('/chats/{id_chat}/mensajes/{mensaje}/{username}', 'MessageController@destroy'); // Eliminar un mensaje en un chat de un usuario*/


