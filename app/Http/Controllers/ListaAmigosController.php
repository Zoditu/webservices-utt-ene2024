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
           "usuario_solicita" => $info[0],
           "usuario_recibe" => $info[1],
           "estado" => 'pendiente'

        ];
        
        $insert = DB::table("amistad")->insert($data);

        return view('busqueda', ["resul" => 'true', "user1" => $info[2], "user2" => $info[3]]);

    }

    public function ver(Request $request){
        $data = new datos();
        $info = $data->getusername($request);

        $amistad = $data->getamistad($request);
        

        if($amistad[0] == null){
            return view('veramistad', ["fecha" => "NO EXISTE AMISTAD", "usu1" => $info[0], "usu2" => $info[1]]);
        }else{
            return view('veramistad', ["fecha" => $amistad[0], "usu1" => $info[0], "usu2" => $info[1]]);
        }
       
    }


    public function block(Request $request){
        $data = new datos();
        $info = $data->getusername($request);

       $data=
        [
           "usuario_quebloquea" => $info[0],
           "usuario_bloqueado" => $info[1],
        ];
        
        $insert = DB::table("bloqueo")->insert($data);

        return view('busqueda', ["resul" => 'true', "user1" => $info[2], "user2" => $info[3]]);
    }

    public function respondersoli(Request $request){
        $data = new datos();
        $info = $data->getusername($request);
        $respuestaboton = $request->get('respuesta');
        $amistad = $data->getamistad($request);

        if($respuestaboton == "true"){
            $update = DB::update("update amistad set estado = 'aceptada' where id_amistad = 
            '".$amistad[1]."'");
            $respuesta = "aceptada";
            return view('busqueda2', ["res" => $respuesta, "user1" => $info[2], "user2" => $info[3]]);
        }else{
            $update = DB::update("update amistad set estado = 'rechazada' where id_amistad = 
            '".$amistad[1]."'");
            return view('busqueda', ["resul" => 'false', "user1" => $info[2], "user2" => $info[3]]);
        }

    }

        public function eliminar(Request $request){
            $data = new datos();
            $info = $data->getusername($request);
            $amistad = $data->getamistad($request);

            $delete = DB::delete("delete from amistad where id_amistad = '".$amistad[1]."'");

            return view('busqueda', ["resul" => 'false', "user1" => $info[2], "user2" => $info[3]]);
        }

        public function desbloquear(Request $request){
            $data = new datos();
            $info = $data->getusername($request);
            $bloqueo = $data->getbloqueo($request);

            $delete = DB::delete("delete from bloqueo where id_bloque = '".$bloqueo."'");

            return "Has desbloqueado al usuario";

        }

    public function prueba(){
        $data = new datos();
        //$infor = $data->getuser();

       // return $infor[0]->username;
    }
 
}
