<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de <?php echo e($username); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        .profile-picture {
            width: 4rem;
            height: 4rem;
            border-radius: 100%;
            opacity: 0.9;
            
        }

        .username-title {
            padding-left: 0.75rem;
            font-size: 3rem;
        }

        .material-symbols-outlined {
            padding-right: 0.75rem;
        }
    </style>
</head>
<body>
    <div class="card">
    <h5 class="card-header">
        <div class="d-flex">
            <img class="profile-picture" src=<?php echo e($image); ?> alt="Imagen de perfil">
            <span class="username-title">
                <?php echo e($username); ?>

            </span>
        </div>
    </h5>
    <div class="card-body resize">
        <h5 class="card-title"><?php echo e($name); ?> <?php echo e($lastName); ?></h5>
        <p class="card-text">
            <div class="d-flex">
                <span class="text-secondary material-symbols-outlined">
                    contact_mail
                </span> <?php echo e($email); ?>

            </div>
            <div class="d-flex">
            <span class="text-secondary material-symbols-outlined">
                    phone
                </span> <?php echo e($phone); ?>

            </div>
            <div class="d-flex">
                <span class="text-secondary material-symbols-outlined">
                    cake
                </span> <?php echo e($birth); ?>

            </div>
        </p>
        <a href="#" class="btn btn-primary">Go somewhere</a>
    </div>
    </div>
</body>
</html><?php /**PATH /Users/castaneda/Desktop/webservices/webservices-utt-ene2024/resources/views/user.blade.php ENDPATH**/ ?>