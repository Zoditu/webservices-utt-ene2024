<?php

namespace App\Http\Controllers;


use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ValidarToken extends Controller
{
    public static function ValidarToken($username)
    {
        //Se crea el token de 16 caracteres
        $token = base64_encode(Str::random(16));


        // $username = session('consultaDelUsuario');

        $insertarToken = DB::table('token')->insert([
            'token' => $token,
            'username' => $username,
        ]);

        $queryToken = DB::table('token')->where('username', $username)->first();

        $consultaToken = $queryToken->token;

        if ($token == null) {
            return new Response(view("error", ["code" => 404, "error" => "No se ha encontrado el token [" . $token . "]"]), 404);
        }

        return $consultaToken;
    }

    public function VTokenPost(Request $request, $token)
    {
        $varToken = $token;

        $queryTokenVal = DB::table("token")->where("token", $varToken)->first();


        if ($queryTokenVal->estado === null) {
            $query = DB::table("token")->where("token", $varToken)->update(["estado" => 1]);
            $queryTokenVal = DB::table("token")->where("token", $varToken)->first();
            return $queryTokenVal->estado;
        } else if ($queryTokenVal->estado === 1) {
            return new Response(view("error", ["code" => 409, "error" => "El usuario ya fue validado"]), 409);
        } else if ($queryTokenVal->estado === 0) {
            return new Response(view("error", ["code" => 409, "error" => "El usuario fue invalidado"]), 409);
        } else if ($token == null) {
            return new Response(view("error", ["code" => 404, "error" => "No se ha encontrado el token [" . $token . "]"]), 404);
        }
    }


    public function CTokenPost(Request $request, $token)
    {
        $varToken = $token;


        //verificar el estado del token
        $queryTokenVal = DB::table("token")->where("token", $varToken)->first();


        if ($queryTokenVal->estado === null) {
            $query = DB::table("token")->where("token", $varToken)->update(["estado" => 0]);
            //estado actualizado
            $queryTokenVal = DB::table("token")->where("token", $varToken)->first();
            return $queryTokenVal->estado;
        } else if ($queryTokenVal->estado === 1) {
            return new Response(view("error", ["code" => 409, "error" => "El Token ya se ha usado"]), 409);
        } else if ($queryTokenVal->estado === 0) {
            return new Response(view("error", ["code" => 409, "error" => "El Token ya fue cancelado"]), 409);
        } else if ($token == null) {
            return new Response(view("error", ["code" => 404, "error" => "No se ha encontrado el token [" . $token . "]"]), 404);
        }
    }
}
