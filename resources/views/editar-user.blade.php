<!-- editar-usuario.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
</head>
<body>
    <h1>Editar Usuario</h1>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ url('/editar-usuario/'.$usuario->username) }}">
        @csrf
        @method('POST')
        
        <!-- Campos del formulario -->
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ $usuario->email }}" required>
        
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="{{ $usuario->name }}" required>

        <label for="lastName">Apellido:</label>
        <input type="text" id="lastName" name="lastName" value="{{ $usuario->lastName }}">
        
        <label for="phone">Teléfono:</label>
        <input type="text" id="phone" name="phone" value="{{ $usuario->phone }}">

        <label for="sex">Sexo:</label>
        <input type="text" id="sex" name="sex" value="{{ $usuario->sex }}">

        <label for="birth">Fecha de Nacimiento:</label>
        <input type="date" id="birth" name="birth" value="{{ $usuario->birth }}">
        
        <!-- Otros campos del usuario -->
        
        <button type="submit">Actualizar información</button>
    </form>
</body>
</html>
