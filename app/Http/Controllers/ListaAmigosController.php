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
        $nombres = $data->getusername($request);


       $data=
        [
           "usuario_solicita" => $nombres[0],
           "usuario_recibe" => $nombres[1],
           "estado" => 'pendiente'

        ];
        
        $insert = DB::table("amistad")->insert($data);

        if($insert){
            return redirect()->route('amigos.busqueda');
        }else{
            return view('error', ["code" => "404", "error" => "NOT FOUND"]);
        }

    }

    public function ver($user1, $user2,Request $request){
        $data = new datos();
        $username1 = $request->route('username1');
        $username2 = $request->route('username2');

        $amistad = $data->getamistad($username1, $username2);
        

        if($amistad[0] == null){
            return view('veramistad', ["fecha" => "NO EXISTE AMISTAD", "usu1" => $user1, "usu2" => $user2]);
        }else{
            return view('veramistad', ["fecha" => $amistad[4], "usu1" => $user1, "usu2" => $user2]);
        }
       
    }


    public function block(Request $request){
        $data = new datos();
        $nombres = $data->getusername($request);

       $data=
        [
           "usuario_quebloquea" => $nombres[0],
           "usuario_bloqueado" => $nombres[1],
        ];
        
        $insert = DB::table("bloqueo")->insert($data);

        if($insert){
        return redirect()->route('amigos.busqueda');
        }else{
            return view('error', ["code" => "404", "error" => "NOT FOUND"]);
        }
    }

    public function respondersoli(Request $request){
        $data = new datos();
        $nombres = $data->getusername($request);
        $amistad = $data->getamistad($nombres[0], $nombres[1]);

            $update = DB::update("update amistad set estado = 'aceptada' where id_amistad = 
            '".$amistad[3]."'");

            if($update){
                return redirect()->route('amigos.busqueda');  
            }else{
                return view('error', ["code" => "404", "error" => "NOT FOUND"]);
            }
    }

        public function eliminar(Request $request){
            $data = new datos();
            $nombres = $data->getusername($request);
            $amistad = $data->getamistad($nombres[0], $nombres[1]);

            $delete = DB::delete("delete from amistad where id_amistad = '".$amistad[3]."'");

            return redirect()->route('amigos.busqueda');

        }

        public function desbloquear(Request $request){
            $data = new datos();
            $nombres = $data->getusername($request);
            $bloqueo = $data->getbloqueo($nombres[0], $nombres[1]);

            $delete = DB::delete("delete from bloqueo where id_bloque = '".$bloqueo[0]."'");

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
    
        $bloqueo = $data->getbloqueo('aaha', 'beny06');
        $amistad = $data->getamistad('aaha','beny06');
    
        if($bloqueo != "vacio"){
            if($bloqueo[1] == 'aaha'){
                return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'desbloquear', 'username1' => 'aaha', 'username2' => 'beny06' ]);
            }else{
                return "NOT FOUND";
            }
           }else{
        switch($amistad[0]){
            case "pendiente":
                if($amistad[1] == "aaha"){
                return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'pendientesolicita', 'username1' => 'aaha', 'username2' => 'beny06' ]);
                }else{
                return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'pendienterecibe', 'username1' => 'aaha', 'username2' => 'beny06'  ]);
                }
            case "aceptada":
                return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'aceptada', 'username1' => 'aaha', 'username2' => 'beny06'  ]);
            case "rechazada":
                return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'rechazada', 'username1' => 'aaha', 'username2' => 'beny06'  ]);
            default:
                return view("busqueda", ['user1' => $str, 'user2' => $str2, "resul" => 'noexiste', 'username1' => 'aaha', 'username2' => 'beny06'  ]);
        }
    }
}

    public function prueba(){
        $data = new datos();
        //$infor = $data->getuser();

       // return $infor[0]->username;
       //return view('search');
       $blok = $data->getbloqueo('aaha', 'beny06');

    }
 
}

?>;