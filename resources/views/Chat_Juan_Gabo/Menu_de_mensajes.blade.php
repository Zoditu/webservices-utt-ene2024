<!DOCTYPE html>
<html>
<head>
    <title>Menú de Contactos</title>
    <style>
        /* Estilos para el menú de contactos similar a WhatsApp */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        #contact-menu {
            width: 250px;
            background-color: #f5f5f5;
            height: 100vh;
            overflow-y: auto;
            border-right: 1px solid #ddd;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 60px;
        }

        #contact-menu h2 {
            margin: 0;
            padding: 10px;
            color: #fff;
            background-color: #001f3f; /* Azul marino */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            text-align: center;
        }

        .contact {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
        }

        .contact:last-child {
            border-bottom: none;
        }

        .contact:hover {
            background-color: #e5e5e5;
        }

        .contact a {
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
        }

        .contact a img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        #add-contact-form {
            padding: 10px;
            border-top: 1px solid #ddd;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #fff;
        }

        #add-contact-button {
            padding: 5px 10px;
            background-color: #128C7E;
            color: #fff;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #add-contact-button:hover {
            background-color: #0E6C5C;
        }
    </style>
</head>
<body>
    <div id="contact-menu">
        <h2>Menú de Contactos</h2>
        <div class="contact">
            <a href="#">
                <img src="{{ asset('avatar1.jpg') }}" alt="Avatar">
                <span>Contacto 1</span>
            </a>
        </div>
        <div class="contact">
            <a href="#">
                <img src="{{ asset('avatar2.jpg') }}" alt="Avatar">
                <span>Contacto 2</span>
            </a>
        </div>
        <!-- Aquí puedes agregar más contactos -->
    </div>

    <form id="add-contact-form" method="post" action="{{ route('agregar_contacto') }}">
        @csrf
        <button id="add-contact-button" type="submit">Agregar nuevo contacto</button>
    </form>
</body>
</html>
