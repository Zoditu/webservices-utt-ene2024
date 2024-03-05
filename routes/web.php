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

Route::get('/profile', function(Request $req) { 
    //create table Usuario(username varchar(20) primary key, name varchar(20), lastName varchar(50), email tinytext, phone varchar(12), sex varchar(20), birth date, password varchar(16), image mediumtext);
    //alter table usuario add column image mediumtext;
    $user = $req->get("user");
    $usuario = null;
    if ($user) {
        $usuario =
            DB::select("select username, name, lastName, email, phone, sex, birth, image from usuario where username='" . $user . "'");

        return !$usuario ? new Response(view("error", ["code" => 404, "error" => "No se ha encontrado el usuario [" . $user . "]"]), 404) : view("user", (array)$usuario[0]);
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
        "email" => "required",
        "name" => "required",
        "lastName" => "optional",
        "password" => "required",
        "birth" => "optional",
        "phone" => "optional",
        "sex" => "optional"
    ]);

    $body = $request->all();

    $username = strtolower($username);
    $email = $body['email'];
    $name = $body['name'];
    $password = bcrypt($body['password']);
    
    DB::table('Usuario')->insert([
        'username' => $username,
        'email' => $email,
        'name' => $name,
        'password' => $password
    ]);

    return [
        'username' => $username,
        'email' => $email,
        'name' => $name,
        'password' => $password
    ];


    //$response = ["resultado" => $count];
    //$response->withCookie(cookie('utt', 'este valor', 100000));
    //$body["username"] = $username;
    //return $body;
});