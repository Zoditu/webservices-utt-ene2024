<?php

use App\Http\Controllers\ListaAmigosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\datos;

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


Route::post('amigos/añadir', [ListaAmigosController::class, 'add'])->name('amigos.add');
Route::put('amigos/responder', [ListaAmigosController::class, 'respondersoli'])->name('amigos.respondersoli');
Route::delete('amigos/eliminar', [ListaAmigosController::class, 'eliminar'])->name('amigos.eliminar');
Route::post('amigos/bloquear', [ListaAmigosController::class, 'block'])->name('amigos.block');
Route::delete('amigos/desbloquear', [ListaAmigosController::class, 'desbloquear'])->name('amigos.unblock');
//agregar en el controlador por paths buscar la amistad. PENDIENTE
Route::get('amigos/ver', [ListaAmigosController::class, 'ver'])->name('amigos.ver');


//hacer un controller de la vista de busqueda para que en esa viste verifique si existe una amistad y en que estado esta
// o si el usuario esta bloqueado y asi saber que opciones se deben mostrar.
//ejemplo de vista de quien manda solicitu de amistad
Route::get('busqueda/perfilresultado', function(){
    $data = new datos();

    $result = DB::selectOne("select name from usuario where username= 'aaha'");
    $user = array_values((array)$result);
    $str = implode($user);

    $result2 = DB::selectOne("select name from usuario where username= 'beny06'");
    $user2 = array_values((array)$result2);
    $str2 = implode($user2);

    $bloqueo = $data->getbloqueotemporal('aaha', 'beny06');
    $amistad = $data->getamistadtemporal('aaha','beny06');

    if($bloqueo != "vacio"){
        if($bloqueo[1] == 'aaha'){
            return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'desbloquear' ]);
        }else{
            return "NOT FOUND";
        }
       }else{
    switch($amistad[0]){
        case "pendiente":
            if($amistad[1] == "aaha"){
            return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'pendientesolicita' ]);
            }else{
            return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'pendienterecibe' ]);
            }
        case "aceptada":
            return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'aceptada' ]);
        case "rechazada":
            return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'rechazada' ]);
        default:
            return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'noexiste' ]);
    }
}

   // if($bloqueo != "vacio"){
     //   return "NOT FOUND";
    //}
    //elseif($amistad[2] == "pendiente"){
      //  return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'pendiente' ]);
    //}elseif($amistad[2] == "aceptada"){
      //  return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'aceptada' ]);
    //}elseif($amistad[2] == "rechazada"){
      //  return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'rechazada' ]);
    //}elseif($amistad == "no existe"){
      //  return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'noexiste' ]);
    //}
})->name('amigos.busqueda');

//ejemplo de vista de quien recibe solicitud de amist
Route::get('busqueda/perfilresultado2', function(){
    $result = DB::selectOne("select name from usuario where username= 'aaha'");
    $user = array_values((array)$result);
    $str = implode($user);

    $result2 = DB::selectOne("select name from usuario where username= 'beny06'");
    $user2 = array_values((array)$result2);
    $str2 = implode($user2);
    return view("busqueda2", ['user1' => $str, 'user2' => $str2, "res" => '' ]);
})->name('amigos.busqueda2');

Route::get('prueba', [ListaAmigosController::class, 'prueba']);
