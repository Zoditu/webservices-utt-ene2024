<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMISTAD</title>
</head>
<body>
    <h1>Eres amigo de {{$usu2}} desde el {{date('d-m-Y', strtotime($fecha->fecha))}}</h1>

    <form action="{{ route('amigos.busqueda') }}" method="get">
    <button type="submit">Regresar</button>
    

</form>
</body>
</html>