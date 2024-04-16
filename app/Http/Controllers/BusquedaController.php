<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusquedaController extends Controller
{
    public function buscar(Request $request)
    {
        $query = $request->query('q');

        // Consulta para encontrar publicaciones y usuarios relacionados con el término de búsqueda
        $resultados = DB::select("
            SELECT u.Username, u.name, u.lastName, p.Contenido
            FROM Usuario u
            LEFT JOIN Publicacion p ON u.Username = p.FK_Usuario
            WHERE u.Username LIKE '%$query%'
            OR u.name LIKE '%$query%'
            OR u.lastName LIKE '%$query%'
            OR p.Contenido LIKE '%$query%'
        ");

        // Consulta para encontrar usuarios relacionados con el término de búsqueda
        $usuarios = DB::select("
            SELECT username, name, lastName, image
            FROM Usuario
            WHERE Username LIKE '%$query%'
            OR name LIKE '%$query%'
            OR LastName LIKE '%$query%'
        ");

        // Consulta para encontrar publicaciones relacionadas con el término de búsqueda
        $publicaciones = DB::select("
            SELECT p.Contenido, p.Fecha_Hora, u.Username
            FROM Publicacion p
            JOIN Usuario u ON p.FK_Usuario = u.Username
            WHERE p.Contenido LIKE '%$query%'
        ");

        return view('resultado_busqueda', compact('resultados', 'usuarios', 'publicaciones'));
    }
}