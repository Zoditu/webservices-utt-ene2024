<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Datos{
    public function getuser(Request $request){
        $user1 = $request->get('user1');
        $user2 = $request->get('user2');

        $result = DB::selectOne("select username from usuario where name= '".$user1."'");
        $result2 = DB::selectOne("select username from usuario where name= '".$user2."'");

        return [$result, $result2, $user1, $user2];
    }
}
?>;