<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
    <style>
             /* CSS para el chat */
             body {
            font-family: Arial, sans-serif; /* Fuente de letra común */
            color: #fff; /* Color del texto blanco */
            margin: 0; /* Eliminar márgenes predeterminados */
            padding: 0; /* Eliminar relleno predeterminado */
        }

        #header {
            background-color: #001f3f; /* Azul marino */
            text-align: center; /* Centrar el texto */
            padding: 10px;
        }

        #chat-container {
            width: 100%;
            height: 400px;
            overflow-y: scroll;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #fff; /* Fondo blanco */
            color: #000; /* Color del texto negro */
        }

        .message {
            margin-bottom: 10px;
            padding: 10px; /* Ajuste el espacio interno para dar espacio a los bordes */
            border-radius: 20px; /* Hacer los bordes redondeados */
            max-width: 80%; /* Limitar el ancho del globo de texto */
            word-wrap: break-word; /* Romper palabras largas */
        }

        /* Estilos para los mensajes del usuario local */
        .message.local {
            background-color: #add8e6; /* Azul claro o cielo */
            margin-left: auto; /* Alinear a la derecha */
        }

        /* Estilos para los mensajes de otros usuarios */
        .message.other {
            background-color: #ccc; /* Gris */
            margin-right: auto; /* Alinear a la izquierda */
        }

        #message-form {
            margin-top: 10px;
            display: flex; /* Usar flexbox */
            align-items: center; /* Centrar elementos verticalmente */
        }

        #message-input {
            flex: 1; /* Hacer que el input ocupe todo el espacio disponible */
            padding: 5px;
            border: 1px solid #ccc;
        }

        #send-button {
            padding: 5px;
            border: none;
            background-color: #006400; /* Dark green */
            color: #fff; /* Color del texto blanco */
            font-weight: bold; /* Negrita */
            cursor: pointer;
        }

        /* Estilos responsivos */
        @media only screen and (max-width: 600px) {
            #chat-container {
                height: 300px; /* Reducir la altura en dispositivos móviles */
            }
        }
    </style>
</head>
<body>
    <!-- Encabezado del chat -->
    <div id="header">
        <h1>Chat</h1>
    </div>

    <!-- Contenido del chat -->
    <div id="chat-container">
        <!-- Mensajes del chat -->
        @foreach ($messages as $message)
            <div class="message {{ $message->user_id === auth()->id() ? 'local' : 'other' }}">
                <strong>{{ $message->user->name }}:</strong> {{ $message->content }}
            </div>
        @endforeach
    </div>

    <!-- Formulario para enviar mensajes -->
    <form id="message-form" method="post" action="{{ route('send_message') }}">
        @csrf
        <input type="text" id="message-input" name="content" placeholder="Escribe tu mensaje aquí">
        <button id="send-button" type="submit">Enviar</button>
    </form>
</body>
</html>
