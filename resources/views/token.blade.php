<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Activacion Token</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>


<style>
  .verification__title {
    color: var(--color-primary);
  }

  body,
  html {
    background: #fbffff;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
  }

  .btn-zoom {
    transition: transform 0.3s ease;
  }

  .btn-zoom:hover {
    transform: scale(1.1);
  }
</style>

<body>

  <div class="row d-flex align-items-center m-0" style="margin-top:100px">

    <div class="col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
      <h2 class="verification__title text-center">¡Activa tu Token!</h2>
      <br><br><br>

      <div style="margin:5%; margin-top:0px; margin-bottom:0px">
        <p>Para activar tu Token y activar tu cuenta, sigue estos sencillos pasos:</p>
        <p><b>1. </b> Haz clic en el botón "Activar" a continuación.</p>
        <p><b>2. </b> Una vez activado, tu Token se dara de alta y se activara tu cuenta, de ese mismo modo podras iniciar sesión.</p>
        <br>
      </div>

      <center>
        <div class="row text-center container">
          <div class="col-6">
            <button type="button" id="activarBtn" class="btn-block btn-zoom btn-activar" style="background:#1a2556; color:white; border-radius:10px; border:0px; font-size:20px; padding:3%; width:100%">Activar</button>
          </div>

          <div class="col-6">
            <button class="btn-block btn-zoom btn-cancelar" id="cancelarBtn" type="button" style="background:#1a2556; color:white; border-radius:10px; border:0px; font-size:20px; padding:3%; width:100%">Cancelar</button>
          </div>
        </div>
      </center>
      <br><br>
    </div>




    <div class="d-none d-sm-block col-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
      <center>
        <img style="width:75%; heigth:75%; " src="https://github.com/herbstluft/t/blob/master/avatar_token.png?raw=false" alt="" srcset="">
      </center>
    </div>


  </div>

  <script>
    var tokenGenerado = "{{ $tokenGenerado ?? '' }}";

    $(document).ready(function() {
      $('#activarBtn').click(function() {
        window.location.href = '/token/estado/' + tokenGenerado;
      });

      $('#cancelarBtn').click(function() {
        window.location.href = '/token/deny/' + tokenGenerado;
      });
    });
  </script>
</body>

</html>