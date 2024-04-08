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
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ChatController;

Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');


Route::get('/db', function(Request $req) { 
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

Route::get('/p', function(Request $request) {
    return $request->fullUrl();
});

Route::get('/', function(Request $request) {
    $queryParams = (object)$request->all();
    $nombre = "no name was given";
    if(property_exists($queryParams, "nombre")) {
        $property = "nombre";
        $nombre = $queryParams->$property;
        //$queryParams["nombre"]
    }

    return view('test', ['name' => $nombre]);
});

//MENSAJE
// Leer mensaje
Route::get('/mensajes', 'MessageController@index');

// Enviar mensaje
Route::post('/mensajes', 'MessageController@store');

// Editar mensaje
Route::put('/mensajes/{id_mensaje}', 'MessageController@update');

// Eliminar mensaje
Route::delete('/mensajes/{id_mensaje}', 'MessageController@destroy');

// Leer nuevo mensaje en un chat de un usuario
Route::get('/chats/{id_chat}/mensajes/{mensaje}/{id_usuario}', 'MessageController@show');

// Almacenar un nuevo mensaje en un chat de un usuario
Route::post('/chats/{id_chat}/mensajes/{mensaje}/usuarios/{id_usuario}', 'MessageController@store');

// Actualizar un mensaje en un chat de un usuario
Route::put('/usuarios/{id_usuario}/chats/{id_chat}/mensajes/{id_mensaje}/{mensaje}', 'MessageController@update');

// Eliminar un mensaje en un chat de un usuario
Route::delete('/usuarios/{id_usuario}/chats/{id_chat}/mensajes/{id_mensaje}/{mensaje}', 'MessageController@destroy');