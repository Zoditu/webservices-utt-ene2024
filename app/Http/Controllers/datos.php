<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Datos{
    public function getusername(Request $request){
        $user1 = $request->input('username1');
        $user2 = $request->input('username2');

        return [$user1, $user2];
    }

    public function getamistad($username1, $username2){

        $result = DB::selectOne("select fecha, id_amistad, estado, usuario_solicita, usuario_recibe from amistad where usuario_solicita= '".$username2."' and 
        usuario_recibe= '".$username1."'");
        $result2 = DB::selectOne("select fecha, id_amistad, estado, usuario_solicita, usuario_recibe from amistad where usuario_solicita= '".$username1."' and 
        usuario_recibe= '".$username2."'");

        if($result == null){
            if($result2 == null){
                return "no existe";
            }else{
            return [$result2->estado, $result2->usuario_solicita, $result2->usuario_recibe, $result2->id_amistad, $result2->fecha];
            }
        }else{
            return [$result->estado, $result->usuario_solicita, $result->usuario_recibe, $result->id_amistad, $result->fecha];
        }
    }

    public function getbloqueo($username1, $username2){

        $result = DB::selectOne("select id_bloque, usuario_quebloquea, usuario_bloqueado from bloqueo where usuario_quebloquea= '".$username2."' and 
        usuario_bloqueado= '".$username1."'");
        $result2 = DB::selectOne("select id_bloque, usuario_quebloquea, usuario_bloqueado from bloqueo where usuario_quebloquea= '".$username1."' and 
        usuario_bloqueado= '".$username2."'");

        if($result == null){
            if($result2 == null){
                return "vacio";
            }else{
                return [$result2->id_bloque, $result2->usuario_quebloquea, $result2->usuario_bloqueado];
            }
        }else{
            return [$result->id_bloque, $result->usuario_quebloquea, $result->usuario_bloqueado];
        }
    }

  



}
?>;