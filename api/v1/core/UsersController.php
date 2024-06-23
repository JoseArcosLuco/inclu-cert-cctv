<?php
    require_once('includes/Tokens.class.php');
    require_once('includes/Users.class.php');

    # validar token bearer 
    # code...

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
                # code...
                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['idPerfil']) && isset($_GET['nombres']) && isset($_GET['apellidos']) && isset($_GET['email']) && isset($_GET['password']) && isset($_GET['codigogoogle2fa'])){
                        Users::create_users($_GET['idPerfil'], $_GET['nombres'], $_GET['apellidos'], $_GET['email'], $_GET['password'], $_GET['codigogoogle2fa']);
                }


            break;
        case 'GET':
                # code...
                if($_SERVER['REQUEST_METHOD'] == 'GET'){
                        Users::get_all_users() ;
                }
    
    
                break;    
        
            

        default:
            # code...
            break;
    }
?>