<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Búsqueda</title>
</head>
<body>
    <h1>Resultado de Búsqueda</h1>

    <form action="{{ url('/busqueda') }}" method="GET">
        <input type="text" name="q" placeholder="Buscar...">
        <button type="submit">Buscar</button>
    </form>

    <h2>Resultados</h2>
    @if (count($resultados) > 0)
        <ul>
            @foreach ($resultados as $resultado)
                <li>{{ $resultado->name }} {{ $resultado->lastName }}: {{ $resultado->Contenido }}</li>
            @endforeach
        </ul>
    @else
        <p>No se encontraron resultados.</p>
    @endif
</body>
</html>