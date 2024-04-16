<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Algo salió mal...</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        .error-code {
            color: #969696;
            font-size: 4em;
        }

        .error-code:first-letter {
            color: darkred;
        }

        .glitch {
            position: absolute;
            left: 0;
            top: 0;
            background-image: url(https://cdn.wallpapersafari.com/68/2/HzSDdW.jpg);
            background-size: 100% 100%;
            z-index: 100;
            filter: opacity(0.25) invert(1);
        }
    </style>
</head>
<body class="vh-100 bg-light">
    <main class="container h-100">
        <article class="glitch w-100 h-100"></article>
        <section class="row h-100">
            <div class="col align-self-center">
                <div class="text-center">
                    <h1 class="error-code">{{$code}}</h1>
                    <h2>{{$error}}</h2>
                </div>
            </div>
        </section>
    </main>
</body>
</html>