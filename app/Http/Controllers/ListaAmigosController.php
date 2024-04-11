<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\datos;
use App\Http\Controllers\Redirect;


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

        if($insert){
            return redirect()->route('amigos.busqueda');
        }else{
            return view('error', ["code" => "404", "error" => "NOT FOUND"]);
        }

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

        if($insert){
        return redirect()->route('amigos.busqueda');
        }else{
            return view('error', ["code" => "404", "error" => "NOT FOUND"]);
        }
    }

    //CAMBIAR EL RECHAZAR, SI LA RECHAZA DEBE ELIMINAR EL REGISTRO DE LA SOLICITUD DE LA TABLA
    public function respondersoli(Request $request){
        $data = new datos();
        $info = $data->getusername($request);
        $respuestaboton = $request->get('respuesta');
        $amistad = $data->getamistad($request);

        if($respuestaboton == "true"){
            $update = DB::update("update amistad set estado = 'aceptada' where id_amistad = 
            '".$amistad[1]."'");
            $respuesta = "aceptada";

            if($update){
                return redirect()->route('amigos.busqueda');  
            }else{
                return view('error', ["code" => "404", "error" => "NOT FOUND"]);
            }
        }else{
            $update = DB::update("update amistad set estado = 'rechazada' where id_amistad = 
            '".$amistad[1]."'");

            if($update){
                return redirect()->route('amigos.busqueda');  
            }else{
                return view('error', ["code" => "404", "error" => "NOT FOUND"]);
            }
        }
    }

        public function eliminar(Request $request){
            $data = new datos();
            $info = $data->getusername($request);
            $amistad = $data->getamistad($request);

            $delete = DB::delete("delete from amistad where id_amistad = '".$amistad[1]."'");

            return redirect()->route('amigos.busqueda');

        }

        public function desbloquear(Request $request){
            $data = new datos();
            $info = $data->getusername($request);
            $bloqueo = $data->getbloqueo($request);

            $delete = DB::delete("delete from bloqueo where id_bloque = '".$bloqueo."'");

            return redirect()->route('amigos.busqueda');

        }



    
    public function search(){
        $data = new datos();

        $result = DB::selectOne("select name from usuario where username= 'aaha'");
        $user = array_values((array)$result);
        $str = implode($user);
    
        $result2 = DB::selectOne("select name from usuario where username= 'beny06'");
        $user2 = array_values((array)$result2);
        $str2 = implode($user2);
    
        $bloqueo = $data->getbloqueotemporal('aaha', 'beny06');
        $amistad = $data->getamistadtemporal('aaha','beny06');
    
        if($bloqueo != "vacio"){
            if($bloqueo[1] == 'aaha'){
                return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'desbloquear' ]);
            }else{
                return "NOT FOUND";
            }
           }else{
        switch($amistad[0]){
            case "pendiente":
                if($amistad[1] == "aaha"){
                return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'pendientesolicita' ]);
                }else{
                return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'pendienterecibe' ]);
                }
            case "aceptada":
                return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'aceptada' ]);
            case "rechazada":
                return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'rechazada' ]);
            default:
                return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'noexiste' ]);
        }
    }
}

    public function prueba(){
        $data = new datos();
        //$infor = $data->getuser();

       // return $infor[0]->username;
       //return view('search');
       $blok = $data->getbloqueotemporal('aaha', 'beny06');

    }
 
}
