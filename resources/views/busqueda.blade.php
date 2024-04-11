<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESULTADO DE BUSQUEDA</title>
</head>
<body>

<h1>Usuario logeado: {{strtoupper($user1)}}</h1>

<h3>Usuario buscado: {{strtoupper($user2)}}</h3>

@if($resul == 'aceptada')
<form action="{{ route('amigos.ver') }}" method="get">
    @csrf
    <input type="hidden" name="user1" value="{{$user1}}">
    <input type="hidden" name="user2" value="{{$user2}}">
<button type="submit">Ver Amistad</button>
</form>

<form action="{{ route('amigos.block') }}" method="POST">
        @csrf
        <input type="hidden" name="user1" value="{{$user1}}">
        <input type="hidden" name="user2" value="{{$user2}}">
        <button type="submit">Bloquear</button>
    </form>
</form>

<form action="{{ route('amigos.eliminar') }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="hidden" name="user1" value="{{$user1}}">
        <input type="hidden" name="user2" value="{{$user2}}">
        <button type="submit">Eliminar</button>
</form>


@endif
    
<form action="{{ route('amigos.add') }}" method="post">
    @csrf
    <input type="hidden" name="user1" value="{{$user1}}">
    <input type="hidden" name="user2" value="{{$user2}}">
    @if($resul == 'pendientesolicita')
    <button type="submit">Solicitud enviada</button>
    @elseif($resul == 'rechazada' | $resul == 'noexiste')
    <button type="submit">Añadir a amigos</button>
    @endif

</form>

@if($resul == 'pendienterecibe')
<p>{{$user2}} te ha enviado una solicitud de amistad</p>
<form action="{{ route('amigos.respondersoli') }}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="user1" value="{{$user1}}">
    <input type="hidden" name="user2" value="{{$user2}}">
<button type="submit" name="respuesta" value="true">Aceptar</button>
</form>

<form action="{{ route('amigos.eliminar') }}" method="POST">
    @csrf
    @method('DELETE')
    <input type="hidden" name="user1" value="{{$user1}}">
    <input type="hidden" name="user2" value="{{$user2}}">
<button type="submit" name="respuesta" value="false">Rechazar</button>
</form>
@endif


@if($resul == 'desbloquear')
    <form action="{{ route('amigos.unblock') }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="hidden" name="user1" value="{{$user1}}">
        <input type="hidden" name="user2" value="{{$user2}}">
        <button type="submit">Desbloquear</button>
    </form>
@endif



</body>
</html>