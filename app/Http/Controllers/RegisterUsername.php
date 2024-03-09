<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\View;
use Illuminate\Support\Facades\DB;

class RegisterUsername extends Controller
{
    public function RegisterUser(Request $request, $username)
    {

        /*$query = $request->all(); //Trae todo, tanto query como body
            $body = $request->getContent(); //body como contenido de texto
            $response = new Response(["username" => "Quiero registrar a: " . $username,
                "params" => $query,
                "body" => json_decode($body) //Parsear el contenido del texto
            ]);*/

        $username = strtolower($username); //Estandarizar el username a lowercase
        preg_match("/[a-zñ0-9\-_]{4,}/", $username, $matches);
        if (count($matches) != 1) {
            return new Response(["error" => "El usuario debe ser solo con caracteres del tipo letras, números, - y _ y mínimo 4 caracteres (" . $username . ")"], 400);
        } else if (strlen($matches[0]) != strlen($username)) {
            return new Response(["error" => "El usuario debe ser solo con caracteres del tipo letras, números, - y _ y mínimo 4 caracteres (" . $username . ")"], 400);
        }

        $count = DB::selectOne("select count(username) from usuario where username = '" . $username . "'");

        $keys = array_keys((array)$count);
        $count = (array)$count;

        if ($count[$keys[0]] != 0) {
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

        $usuario = null;
        $usuario = DB::select("select username, name, lastName, email, phone, sex, birth, image from usuario where username='" . $username . "'");

        return view('token',  (array)$usuario[0]);

        // return (array)$usuario[0];
    }
}
