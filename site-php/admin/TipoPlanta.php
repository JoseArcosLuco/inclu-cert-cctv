<?php 
    include("../includes/TipoPlanta.class.php");

    if(isset($_POST['acciones'])){
        
        isset($_POST['nombre']) ? $nombre = trim($_POST['nombre']) : $nombre = '';
        isset($_POST['estado']) ? $estado = trim($_POST['estado']) : $estado = '';
        isset($_POST['acciones']) ? $acciones = trim($_POST['acciones']) : $acciones = '';

        switch($acciones){ 
            case 'agregar':
                if(!empty($nombre) && !empty($estado)){
                    try {
                    $tipoplanta = new TipoPlanta();
                    $resp = $tipoplanta->create_tipo_planta($nombre);
                    echo 'sucess';
                    } catch(Exception $e) {
                        echo'fail'. $e->getMessage() .'';
                    }
                    // if ($resp->success()){
                    //     echo 'sucess';
                    // }else{
                    //     echo $resp->error();
                    // }
                }

                break;
            case 'eliminar':
                break;
            case 'editar':
                break;
            default:
                echo 'Fail';
                break;
        }
    }
?>