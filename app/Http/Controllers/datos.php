<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Datos{
    public function getuser(Request $request){
        $user1 = $request->get('user1');
        $user2 = $request->get('user2');

        return [$user1, $user2];
    }
    public function getusername(Request $request){
        $nombre = $this->getuser($request);

        $result = DB::selectOne("select username from usuario where name= '".$nombre[0]."'");
        $result2 = DB::selectOne("select username from usuario where name= '".$nombre[1]."'");

        return [$result->username, $result2->username, $nombre[0], $nombre[1]];
    }

    public function getamistad(Request $request){
        $username = $this->getusername($request);

        $result = DB::selectOne("select fecha, id_amistad from amistad where usuario_solicita= '".$username[1]."' and 
        usuario_recibe= '".$username[0]."'");
        $result2 = DB::selectOne("select fecha, id_amistad from amistad where usuario_solicita= '".$username[0]."' and 
        usuario_recibe= '".$username[1]."'");

        if($result == null){
            return [$result2->fecha, $result2->id_amistad];
        }else{
            return [$result->fecha,$result->id_amistad];
        }
    }

    public function getbloqueo(Request $request){
        $username = $this->getusername($request);

        $result = DB::selectOne("select id_bloque from bloqueo where usuario_quebloquea= '".$username[1]."' and 
        usuario_bloqueado= '".$username[0]."'");
        $result2 = DB::selectOne("select id_bloque from bloqueo where usuario_quebloquea= '".$username[0]."' and 
        usuario_bloqueado= '".$username[1]."'");

        if($result == null){
            return $result2->id_bloque;
        }else{
            return $result->id_bloque;
        }
    }


    public function getamistadtemporal($username1, $username2){

        $result = DB::selectOne("select estado, usuario_solicita, usuario_recibe from amistad where usuario_solicita= '".$username2."' and 
        usuario_recibe= '".$username1."'");
        $result2 = DB::selectOne("select estado, usuario_solicita, usuario_recibe from amistad where usuario_solicita= '".$username1."' and 
        usuario_recibe= '".$username2."'");

        if($result == null){
            if($result2 == null){
                return "no existe";
            }else{
            return [$result2->estado, $result2->usuario_solicita, $result2->usuario_recibe];
            }
        }else{
            return [$result->estado, $result->usuario_solicita, $result->usuario_recibe];
        }
    }

    public function getbloqueotemporal($username1, $username2){

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

    public function getusername2($user1, $user2){

        $result = DB::selectOne("select username from usuario where name= '".$user1."'");
        $result2 = DB::selectOne("select username from usuario where name= '".$user2."'");

        return [$result->username, $result2->username, $user1, $user2];
    }



}
?>;