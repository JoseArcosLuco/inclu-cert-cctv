<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once('./includes/Users.class.php');
require_once('./includes/Token.class.php');
$_SESSION["user"]=isset($_POST['usuario']);
$_SESSION["pass"]=isset($_POST['password']);
$_SESSION["idperfil"] = 0;
$_SESSION["falla"]=0;
?>

<? 
if (isset($_POST['usuario']))
{ 
    // Tomamos el valor ingresado
    $sql = trim($_POST['usuario']);
    // Si está vacío, lo informamos, sino realizamos la búsqueda
    if(empty($sql)){
        echo "No se ha ingresado una cadena a buscar";
    } else {
            
            $user=$_POST['usuario'];
            $pass=$_POST['password'];
            //$idapp=$_POST['idapp'];
            /* Asignamos a las variables $user y $pass los valores "usuario" y "clave" recogidos de nuestro formulario de ingreso de la página HTML. */ 
            if(empty($user)) { 
                echo "<p style='color:red;'>No ha ingresado un nombre de usuario.";
                $_SESSION["falla"]=1;
            } 
                /* Utilizaremos la función empty de PHP mediante la cual preguntaremos si nuestra variable $user (la que contiene el valor de usuario del formulario) se encuentra vacia, lo que significaría que el usuario no ingreso nada en el campo. Si este fuera el caso, desplegaríamos un mensaje en la página con "echo" y luego cambiariamos el valor de nuestra variable "falla" (la bandera definida en el vector de sesión) a 1. En caso de que el usuario no este vacío, pasamos al else y revisamos lo demás */
                else{ 
                    
                    if(empty($pass)) { 
                        echo "<p style='color:red;'>No ha ingresado una password.";
                        $_SESSION["falla"]=1;
                } /* Haremos la misma comprobación anterior pero en este caso con la variable $pass (que almacena el valor de password del formulario). En caso de que no este vacía, pasamos al else */
                else{ 
                    
                    $database = new Database();
                    $hash = Users::hashearPass($pass);
                    $conn = $database->getConnection();
                    $stmt = $conn->prepare('SELECT u.id as idusuario,u.email,u.password,p.id as idperfil,p.nombre as nombreperfil,u.nombres as nombreuser,u.apellidos FROM cctv_users as u inner join cctv_perfil as p on u.id_perfil = p.id WHERE u.email=:email and u.password = :password and u.estado=1 and p.estado=1');
                    $stmt->bindParam(':email',$user);
                    $stmt->bindParam(':password',$hash);
                    if($stmt->execute()){
                        $result = $stmt->fetchAll();
                        //var_dump($result);
                        //echo 'paso por aquii';
                        $rows = $stmt->rowCount();
                        if($rows>0){
                            $_SESSION["falla"]=0;
                        }else{
                            $_SESSION["falla"]=1;
                        }
                    } else {
                        $_SESSION["falla"]=1;
                    }
                    
                    
                $resultado = $result;

                if(!$resultado) { 
                    //$error=mysql_error();
                    //print $error;
                    $_SESSION["falla"]=1;
                    //exit(); 
                } 
                
                if(count($resultado)==0) {
                ?>
                    <div class="alert alert-danger">
                        <strong>ERROR!</strong> Usuario incorrecto
                    </div>
                <?
                    $_SESSION["falla"]=1;
                    //exit();
                } /* Luego mediante otro if , hacemos un llamado a la función mysql_affected_rows() la cual se encarga de notificar si es que la consulta no afecto a ninguna fila de nuestra tabla (o sea, no hubo coincidencias), esta función retorna un entero, que es 0 en caso de no haber filas afectadas. En caso de que así sea desplegamos un mensaje informando que el usuario no fue encontrado mediante la sentencia "echo", cambiamos el valor de la variable falla del vector de sesión y finalmente salimos del código mediante la función exit();. Si el resultado de la función no es cero, significa que hubo coincidencias y pasamos al else */ 

                else { 
                
                
                
                //echo 'paso por aquiii';

                $idperfil=0;
                $nombreperfil='';
                $email='';
                $id=0;
                $nombreuser='';
                $apellidos='';
                $passwordbd='';
                
                foreach ( $result as $data) {
                    // ...
                    $idperfil=$data['idperfil'];
                    $nombreperfil=$data['nombreperfil'];
                    $email=$data['email'];
                    $id=$data['idusuario'];
                    $nombreuser=$data['nombreuser'];
                    $apellidos=$data['apellidos'];
                    $passwordbd=$data['password'];

                    //echo '<br>paso por aquiii while pdo';
                }

              

                if($user==$email) { 
                    if($hash==$passwordbd) {
                        $_SESSION['idperfil'] = $idperfil;
                        $_SESSION['nombreperfil'] = $nombreperfil;
                        $_SESSION['idapp'] = 1;
                        $_SESSION["nombre"]=$nombreuser;
                        $_SESSION["apellidos"]=$apellidos;
                        $_SESSION["iduser"]=$id;
                        $_SESSION["email"]=$email;
                        $fecha_hora = date("Y-m-d H:i:s");
                        $token = Token::str_rand();
                        $_SESSION["token"]=$token;

                    $database = new Database();
                    $conn = $database->getConnection();
                    $stmt = $conn->prepare('insert into cctv_tokens (id_users,fecha,token) values (:iduser,:fecha_hora,:token)');
                    $stmt->bindParam(':iduser',$id);
                    $stmt->bindParam(':fecha_hora',$fecha_hora);
                    $stmt->bindParam(':token',$token);
                    if($stmt->execute()){
                        echo "<meta http-equiv='refresh' content='2; url=dashboard.php?token=$token' />";
                    } else {
                    }?>
                        <div class="alert alert-success">Ingresando...</div>
                <?

                } else {?>
                    <div class="alert alert-danger">
                        <strong>ERROR!</strong> Contraseña Incorrecta
                    </div>
                    <meta http-equiv='refresh' content='2; url=error.php?cod=1' />

                <?
                    $_SESSION["falla"]=1;
                } 

                } else { 
                    echo "<p style='color:red;'>Existe un error en el nombre de usuario.</p>";
                    $_SESSION["falla"]=1;
                }
                } } }
            }
}

var_dump($_SESSION["falla"]);
    
?>



<!DOCTYPE html>
<html lang="es-CL"> <!--begin::Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>INCLUSIVE GROUP CCTV APP</title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE 4 | Login Page">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"><!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="./css/adminlte.css"><!--end::Required Plugin(AdminLTE)-->
</head> <!--end::Head--> <!--begin::Body-->

<body class="login-page bg-body-secondary">
    <div class="login-box">
        <div class="login-logo">
            <a href="../index2.html">
                <img src="./assets/img/AdminLTELogo.png" width="100" height="100" alt="Inclusive Group" class="brand-image opacity-75"> 
                <img src="./assets/img/AdminLTEFullLogo.png" width="250" height="100" alt="AdminLTE Logo Large" class="brand-image-xs opacity-75">
                <!--<b>inclusive</b> CCTV -->
            </a> 
        </div> <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Ingresa tus credenciales</p>
                <form id="form1" method="post">
                    <div class="input-group mb-3"> <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Email">
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
                            <div class="d-grid gap-2"> <button type="button" class="btn btn-primary" onClick="actionForm(this.form.id, 'index.php'); return false;">Ingresar</button> </div>
                        </div> <!-- /.col -->
                    </div> <!--end::Row-->
                </form>
                <div class="social-auth-links text-center mb-3 d-grid gap-2">
                    <p>- OR -</p> <a href="#" class="btn btn-primary"> <i class="bi bi-facebook me-2"></i> Sign in using Facebook
                    </a> <a href="#" class="btn btn-danger"> <i class="bi bi-google me-2"></i> Sign in using Google+
                    </a>
                </div> <!-- /.social-auth-links -->
                <p class="mb-1"> <a href="forgot-password.html">Olvido su contraseña?</a> </p>
                <p class="mb-0"> <a href="register.html" class="text-center">
                        Registrar nuevo usuario!
                    </a> </p>
            </div> <!-- /.login-card-body -->
        </div>
    </div> <!-- /.login-box --> <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <div>
    <?
        //Codigo 1 = Sin autorizacion
        //codigo 2 = Sesion cerrada
        //codigo 3 = Periodo de inactividad
        $codigo = isset($_GET['cod']);
        
        switch ("$codigo") {
            case 1:?>
            <div class="alert alert-danger">
                    <strong>ERROR!</strong> Sin autorizacion
                </div>
            <?break;
            case 2:?>
            <div class="alert alert-success" style="color: #FFFFFF;background-color: #498C2D;border-color: #d6e9c6;">
            <strong>Correcto!</strong> Sesion Cerrada
            </div>
            <?break;
            case 3:?>
            <div class="alert alert-info" style="color: #FFFFFF;background-color: #076480;border-color: #bce8f1;">
            <strong>ATENCIÓN! </strong>Para un correcto funcionamineto de la aplicacíon se recomienda utilizar Google Chrome <a href="https://www.google.com/intl/es-419/chrome/browser/desktop/index.html" target="_blank"><img src="../img/google-chrome.ico" width="32" height="32"></a>
                </div>
        <?break;
        }
    ?>
    </div>
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