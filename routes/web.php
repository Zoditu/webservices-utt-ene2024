<?php

use App\Http\Controllers\ListaAmigosController;
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


Route::post('lista-amigos/añadir', [ListaAmigosController::class, 'add'])->name('amigos.add');
Route::put('lista-amigos/respondersoli', [ListaAmigosController::class, 'respondersoli'])->name('amigos.respondersoli');
Route::delete('lista-amigos/eliminar');
Route::post('lista-amigos/bloquear', [ListaAmigosController::class, 'block'])->name('amigos.block');
Route::delete('lista-amigos/desbloquear');
Route::get('lista-amigos/veramistad', [ListaAmigosController::class, 'ver'])->name('amigos.ver');

//ejemplo de vista de quien manda solicitu de amistad
Route::get('busqueda/perfilresultado', function(){
    $result = DB::selectOne("select name from usuario where username= 'aaha'");
    $user = array_values((array)$result);
    $str = implode($user);

    $result2 = DB::selectOne("select name from usuario where username= 'beny06'");
    $user2 = array_values((array)$result2);
    $str2 = implode($user2);
    return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'false' ]);
})->name('amigos.busqueda');

//ejemplo de vista de quien recibe solicitud de amist
Route::get('busqueda/perfilresultado2', function(){
    $result = DB::selectOne("select name from usuario where username= 'aaha'");
    $user = array_values((array)$result);
    $str = implode($user);

    $result2 = DB::selectOne("select name from usuario where username= 'beny06'");
    $user2 = array_values((array)$result2);
    $str2 = implode($user2);
    return view("busqueda2", ['user1' => $str, 'user2' => $str2, "resul" => 'false' ]);
})->name('amigos.busqueda2');

Route::get('prueba', [ListaAmigosController::class, 'prueba'])->name('amigos.ver2');
