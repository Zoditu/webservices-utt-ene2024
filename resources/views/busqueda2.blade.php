<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista de quien recibe solicitud</title>
</head>
<body>
<h1>Usuario logeado: {{strtoupper($user1)}}</h1>

@if($res == null)
<form action="{{ route('amigos.respondersoli') }}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="user1" value="{{$user1}}">
    <input type="hidden" name="user2" value="{{$user2}}">
    <p>{{$user2}} te ha enviado una solicitud de amistad</p>
<button type="submit" name="respuesta" value="true">Aceptar</button>
<button type="submit" name="respuesta" value="false">Rechazar</button>
</form>

@elseif($res == "aceptada")
<form action="{{ route('amigos.eliminar') }}" method="POST">
    @csrf
    @method('DELETE')
    <input type="hidden" name="user1" value="{{$user1}}">
    <input type="hidden" name="user2" value="{{$user2}}">
    <p> {{$user2}} y tu son amigos </p>
    <button type="submit" name="respuesta" value="eliminar">Eliminar amigo</button>
</form>

@elseif($res == "rechazada")
<form action="{{ route('amigos.respondersoli') }}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="user1" value="{{$user1}}">
    <input type="hidden" name="user2" value="{{$user2}}">
    <p>{{$user2}} te ha enviado una solicitud de amistad</p>
<button type="submit" name="respuesta" value="true">Aceptar</button>
<button type="submit" name="respuesta" value="false">Rechazar</button>
</form>
@endif

</body>
</html>