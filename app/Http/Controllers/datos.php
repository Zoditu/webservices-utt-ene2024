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
        $get = $this->getuser($request);

        $result = DB::selectOne("select username from usuario where name= '".$get[0]."'");
        $result2 = DB::selectOne("select username from usuario where name= '".$get[1]."'");

        return [$result->username, $result2->username, $get[0], $get[1]];
    }

    public function getamistad(Request $request){
        $get = $this->getusername($request);

        $result = DB::selectOne("select fecha from amistad where usuario_solicita= '".$get[1]."' and 
        usuario_recibe= '".$get[0]."'");
        $result2 = DB::selectOne("select fecha from amistad where usuario_solicita= '".$get[0]."' and 
        usuario_recibe= '".$get[1]."'");

        if($result == null){
        return [$result2->fecha];
        }else{
            return [$result->fecha];
        }
    }
}
?>;