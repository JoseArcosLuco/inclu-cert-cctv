<?php
include("./includes/Database.class.php");

require_once('./includes/Users.class.php');
require_once('./includes/Token.class.php');
require_once('./includes/Perfil.class.php');

$mensaje = '';

if(isset($_POST['usuario'])){

    $email     = trim($_POST['usuario']);
    $pass      = trim($_POST['password']);
    $idPerfil  = 3; //Ajustar al id Operador
    $nombres   = trim($_POST['primer_nombre']) . ' ' . trim($_POST['segundo_nombre']);
    $apellidos = trim($_POST['primer_apellido']) . ' ' . trim($_POST['segundo_apellido']);
    $codigogoogle2fa = '';//esto para conectar con la cuenta google?

    $result = Users::create_users($idPerfil, $nombres, $apellidos, $email, $pass, $codigogoogle2fa);

    if ($result['status']) {
        header('Location: index.php');
        exit();
    } else {
        $mensaje = $result['message'];
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="ColorlibHQ">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)--> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="./css/adminlte.css"><!--end::Required Plugin(AdminLTE)-->
    <link rel="icon" href="./assets/img/inclusive.ico">
    <title>Registro de Usuarios</title>
</head>
<body>
    <div class="p-5 container">
        <div class="login-logo">
            <a href="../site-php">
                <img src="./assets/img/AdminLTELogo.png" width="100" height="100" alt="Inclusive Group" class="brand-image opacity-75"> 
                <img src="./assets/img/AdminLTEFullLogo.png" width="250" height="100" alt="AdminLTE Logo Large" class="brand-image-xs opacity-75">
                <!--<b>inclusive</b> CCTV -->
            </a> 
        </div> <!-- /.login-logo -->
        <?php if ($mensaje): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($mensaje); ?></div>
        <?php endif; ?>
        <form method="POST" class="form-control p-5">
            <div class="mb-4">
                <label class="form-label w-100">Correo electrónico
                    <input type="email" class="form-control" id="usuario" name="usuario" required>
                </label>
            </div>
            <div class="mb-4">
                <label class="form-label w-100">Contraseña
                    <input type="password" class="form-control" id="password" name="password" required>
                </label>
            </div>
            <div class="mb-4">
                <label class="form-label w-100">Primer Nombre
                    <input type="type" class="form-control" id="primer_nombre" name="primer_nombre" placeholder="Ingresa tu Primer Nombre" required>
                </label>
                <label class="form-label w-100">Segundo Nombre
                    <input type="type" class="form-control" id="segundo_nombre" name="segundo_nombre" placeholder="Ingresa tu Segundo Nombre">
                </label>
            </div>
            <div class="mb-4">
                <label class="form-label w-100">Primer Apellido
                    <input type="type" class="form-control" id="primer_apellido" name="primer_apellido" placeholder="Ingresa tu Primer Apellido" required>
                </label>
                <label class="form-label w-100">Segundo Apellido
                    <input type="type" class="form-control" id="segundo_apellido" name="segundo_apellido" placeholder="Ingresa tu Segundo Apellido">
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script> <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
</html>