<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once('./includes/Users.class.php');
require_once('./includes/Token.class.php');


$_SESSION["user"] = $_POST['usuario'] ?? null;
$_SESSION["pass"] = $_POST['password'] ?? null;
$_SESSION["idperfil"] = 0;
$_SESSION["falla"] = 0;

include('codigos.php');
$mensaje = '';
$codigo = isset($_GET['cod']) ? (int)$_GET['cod']: 0;
$output = getMensajeAlerta($codigo);

if (isset($_POST['usuario'])) { 
    
    $user = trim($_POST['usuario']);
    $pass = trim($_POST['password']);

    if (empty($user)) { 
        echo "<p style='color:red;'>No ha ingresado un nombre de usuario.</p>";
        $_SESSION["falla"] = 1;
    } 
    
    elseif (empty($pass)) { 
        echo "<p style='color:red;'>No ha ingresado una password.</p>";
        $_SESSION["falla"] = 1;
    } 
    
    else { 
        $database = new Database();
        $hash = Users::hashearPass($pass);
        $conn = $database->getConnection();

        // Consulta
        $stmt = $conn->prepare('SELECT u.id as idusuario, u.email, u.password, p.id as idperfil, p.nombre as nombreperfil, u.nombres as nombreuser, u.apellidos 
                                FROM cctv_users as u 
                                INNER JOIN cctv_perfil as p ON u.id_perfil = p.id 
                                WHERE u.email= :email AND u.password= :password AND u.estado=1 AND p.estado=1');
        $stmt->bindParam(':email', $user);
        $stmt->bindParam(':password', $hash);

        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            if (count($result) > 0) {
                $_SESSION["falla"] = 0;
                //data tendrá solo el primer resultado
                $data = $result[0];
                $idperfil = $data['idperfil'];
                $nombreperfil = $data['nombreperfil'];
                $email = $data['email'];
                $id = $data['idusuario'];
                $nombreuser = $data['nombreuser'];
                $apellidos = $data['apellidos'];
                $passwordbd = $data['password'];

                if ($user == $email && $hash == $passwordbd) {
                    $_SESSION['idperfil'] = $idperfil;
                    $_SESSION['nombreperfil'] = $nombreperfil;
                    $_SESSION["nombre"] = $nombreuser;
                    $_SESSION["apellidos"] = $apellidos;
                    $_SESSION["iduser"] = $id;
                    $_SESSION["email"] = $email;
                    $fecha_hora = date("Y-m-d H:i:s");
                    $token = Token::str_rand();
                    $_SESSION["token"] = $token;

                    // Insertar token
                    $stmt = $conn->prepare('INSERT INTO cctv_tokens (id_users, fecha, token) VALUES (:iduser, :fecha_hora, :token)');
                    $stmt->bindParam(':iduser', $id);
                    $stmt->bindParam(':fecha_hora', $fecha_hora);
                    $stmt->bindParam(':token', $token);

                    if ($stmt->execute()) {
                        // Login correcto 
                        echo "<div class='alert alert-success'>Ingresando...</div>";
                        echo "<meta http-equiv='refresh' content='2; url=dashboard.php?token=$token' />";
                    } else {
                        echo "<div class='alert alert-danger'>Error al guardar el token.</div>";
                    }
                } else {
                    // Contraseña Incorrecta
                    echo "<div class='alert alert-danger'><strong>ERROR!</strong> Contraseña Incorrecta</div>";
                    echo "<meta http-equiv='refresh' content='2; url=index.php?cod=2;' />";
                    $_SESSION["falla"] = 1;
                }
            } else {
                // Usuario o Cosntraseña incorrecta
                // var_dump($result);
                echo "<div class='alert alert-danger'><strong>ERROR!</strong> Usuario incorrecto</div>";
                $_SESSION["falla"] = 1;
            }
        } else {
            $_SESSION["falla"] = 1;
        }
    }
}
?>



<!DOCTYPE html>
<html lang="es-CL"> <!--begin::Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>INCLUSIVE GROUP CCTV APP</title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE 4 | Login Page">
    <meta name="author" content="IARCOS">
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"><!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="./css/adminlte.css"><!--end::Required Plugin(AdminLTE)-->
    <link rel="icon" href="./assets/img/inclusive.ico">
</head> <!--end::Head--> <!--begin::Body-->

<body class="login-page bg-body-secondary">
    <?php echo $mensaje ?>
    <div class="login-box">
        <div class="login-logo">
            <a href="../index2.html" tabindex="-1">
                <img src="./assets/img/AdminLTELogo.png" width="100" height="100" alt="Inclusive Group" class="brand-image opacity-75"> 
                <img src="./assets/img/AdminLTEFullLogo.png" width="250" height="100" alt="AdminLTE Logo Large" class="brand-image-xs opacity-75">
                <!--<b>inclusive</b> CCTV -->
            </a> 
        </div> <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Ingresa tus credenciales</p>
                <form id="form1" method="post" class="mb-5">
                    <div class="input-group mb-3"> <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Email" autofocus required tabindex="0">
                        <div class="input-group-text"> <span class="bi bi-envelope"></span> </div>
                    </div>
                    <div class="input-group mb-3"> <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        <div class="input-group-text"> <span class="bi bi-lock-fill"></span> </div>
                    </div> <!--begin::Row-->
                    <div class="row">
                        <div class="col-8">
                            <div class="form-check"> <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"> <label class="form-check-label" for="flexCheckDefault">
                                    Recuerdame!
                                </label> </div>
                        </div> <!-- /.col -->
                        <div class="col-4">
                            <div class="d-grid gap-2"> <button type="submit" class="btn btn-primary" onClick="actionForm(this.form.id, 'index.php'); return false;">Ingresar</button> </div>
                        </div> <!-- /.col -->
                    </div> <!--end::Row-->
                </form>
                <p class="mb-1"> <a href="forgot-password.html">Olvido su contraseña?</a> </p>
            </div> <!-- /.login-card-body -->
        </div>
    </div> <!-- /.login-box --> <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <div class="mt-5"><?php echo $output ?></div>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script> <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="./js/adminlte.js"></script> <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script> <!--end::OverlayScrollbars Configure--> <!--end::Script-->
    <script>
        function actionForm(formid, act)
        {
            document.getElementById(formid).action=act;
            document.getElementById(formid).submit();
        }
    </script>
</body><!--end::Body-->

</html>