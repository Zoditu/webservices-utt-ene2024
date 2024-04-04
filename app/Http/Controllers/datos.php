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
        $get = $this->getusername($request);

        $result = DB::selectOne("select fecha, id_amistad from amistad where usuario_solicita= '".$get[1]."' and 
        usuario_recibe= '".$get[0]."'");
        $result2 = DB::selectOne("select fecha, id_amistad from amistad where usuario_solicita= '".$get[0]."' and 
        usuario_recibe= '".$get[1]."'");

        if($result == null){
            return [$result2->fecha, $result2->id_amistad];
        }else{
            return [$result->fecha,$result->id_amistad];
        }
    }
}
?>;