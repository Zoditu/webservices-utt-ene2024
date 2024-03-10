<?php

namespace App\Http\Controllers;


use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ValidarToken extends Controller
{
    public static function ValidarToken()
    {
        //Se crea el token de 16 caracteres
        $token = base64_encode(Str::random(16));
        $intentos = 0;


        $username = session('consultaDelUsuario');

        $insertarToken = DB::table('token')->insert([
            'token' => $token,
            'username' => $username,
        ]);

        $queryToken = DB::table('token')->where('username', $username)->first();

        session(['tokenGenerado' => $queryToken->token]);
        $consultaToken = session('tokenGenerado');

        // while ($intentos <= 3) {
        //     if ($token == null) {
        //         return new Response(view("error", ["code" => 404, "error" => "No se ha encontrado el token [" . $token . "]"]), 404);
        //         $intentos++;
        //     }
        // }

        return $consultaToken;
    }
}
