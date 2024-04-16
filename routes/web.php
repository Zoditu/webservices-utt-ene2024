<?php

use App\Http\Controllers\RegisterUsername;
use App\Http\Controllers\ValidarToken;
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
use Illuminate\Support\Str;



Route::get('/profile', function (Request $req) {
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


Route::get('/profile', function (Request $req) {
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

//Se creó un controlador llamado RegisterUsername, en él se tienen todas la funciones del endpoint registrar
Route::get('/registrar', [RegisterUsername::class, 'ViewRegister']);

//Se usa el mismo controlador, sólo que se usa la función de RegisterUser
Route::match(['get', 'post'], '/register/{username}', [RegisterUsername::class, 'RegisterUser']);

//También se usan controladores llamados ValidarToken
Route::get('/token/estado/{token}', [ValidarToken::class, 'VTokenPost']);
Route::get('/token/deny/{token}', [ValidarToken::class, 'CTokenPost']);
