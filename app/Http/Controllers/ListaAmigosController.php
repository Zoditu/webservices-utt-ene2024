<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\datos;



class ListaAmigosController extends Controller
{

    public function add(Request $request){
        $data = new datos();
        $info = $data->getusername($request);


       $data=
        [
           "usuario_solicita" => $info[0]->username,
           "usuario_recibe" => $info[1]->username,
           "estado" => 'pendiente'

        ];
        
        $insert = DB::table("amistad")->insert($data);

        return view('busqueda', ["resul" => 'true', "user1" => $info[2], "user2" => $info[3]]);

    }

    public function ver(Request $request){
        $data = new datos();
        $info = $data->getusername($request);

        
        $result = DB::selectOne("select fecha from amistad where usuario_solicita= '".$info[0]."' and 
        usuario_recibe= '".$info[1]."'");
        $result2 = DB::selectOne("select fecha from amistad where usuario_solicita= '".$info[1]."' and 
        usuario_recibe= '".$info[0]."'");

        if($result == null){
            if($result2 == null){
                return view('veramistad', ["fecha" => "NO EXISTE AMISTAD", "usu1" => $info[0], "usu2" => $info[1]]);
            }else{
                return view('veramistad', ["fecha" => $result2, "usu1" => $info[0], "usu2" => $info[1]]);
            }
        }else{
            return view('veramistad', ["fecha" => $result, "usu1" => $info[0], "usu2" => $info[1]]);
        }
       
    }


    public function block(Request $request){
        $user1 = $request->get('user1');
        $user2 = $request->get('user2');

        $result = DB::selectOne("select username from usuario where name= '".$user1."'");
        $result2 = DB::selectOne("select username from usuario where name= '".$user2."'");


       $data=
        [
           "usuario_quebloquea" => $result->username,
           "usuario_bloqueado" => $result2->username,
        ];
        
        $insert = DB::table("bloqueo")->insert($data);

        return view('busqueda', ["resul" => 'true', "user1" => $user1, "user2" => $user2]);
    }

    public function accept(Request $request){
        //obtengo los nombres de la pagina donde se acepta la solicitud de amistad
        $user1 = $request->get('user1');
        $user2 = $request->get('user2');
        $respuestaboton = $request->get('respuesta');

        //a partir de los nombres consulto el user que le corresponde a cada uno
        $result = DB::selectOne("select username from usuario where name= '".$user1."'");
        $result2 = DB::selectOne("select username from usuario where name= '".$user2."'");

        //a partir de los usuarios busco el registro de que la solicitud de amistad ha sido enviada y 
        //obtengo el id de la amistad para posteriormente actuaizar el estado de ese registro
        
        //El usuario que acepta la solicitu siempre sera en la tabla el usuario_recibe
        if($respuestaboton == true){
        $amistad = DB::selectOne("select id_amistad from amistad where usuario_solicita= '".$user2."' and 
        usuario_recibe= '".$user1."'");

        //Comprobar si el registro de la solicitud enviada existe en la tabla amistad
        if($amistad == null){
          $respuesta = false;  
        }else{
            $update = DB::update("update amistad set estado = 'aceptada' where id_amistad = 
            '".$amistad->id_amistad."'");
            if($update){
                $respuesta = true;
            }else{
                $respuesta = false;
            }
        }
    }else{
        $respuesta = "La solicitud fue rechazada";
    }

        return $respuesta;

    }

    public function prueba(){
        $data = new datos();
        //$infor = $data->getuser();

       // return $infor[0]->username;
    }
 
}
