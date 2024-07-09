<?php 
    include("../includes/TipoPlanta.class.php");

    if(isset($_POST['acciones'])){
        isset($_POST['id_aux']) ? $id = trim($_POST['id_aux']) : $id = '';
        isset($_POST['nombre']) ? $nombre = trim($_POST['nombre']) : $nombre = '';
        isset($_POST['estado']) ? $estado = trim($_POST['estado']) : $estado = '';
        isset($_POST['acciones']) ? $acciones = trim($_POST['acciones']) : $acciones = '';

        switch($acciones){ 
            case 'agregar':
                if(!empty($nombre) && !empty($estado)){
                    try {
                        $tipoplanta = new TipoPlanta();
                        if(!$tipoplanta->get_tipo_planta_by_name(trim($nombre))){
                            $resp = $tipoplanta->create_tipo_planta($nombre);
                            echo 'sucess';
                        }else{
                            echo 'fail: registro ya se encuentra en bdd';
                        }
                    } catch(Exception $e) {
                        echo'fail:'. $e->getMessage() .'';
                    }
                }

                break;
            case 'eliminar':
                if(!empty($id)){
                    try {
                        $tipoplanta = new TipoPlanta();
                        if($id>0){
                            $resp = $tipoplanta->delete_tipo_planta_by_id($id);
                            echo 'sucess:'.$resp;
                        }else{
                            echo 'fail: registro no se encuentra en bdd';
                        }
                    } catch(Exception $e) {
                        echo'fail'. $e->getMessage() .'';
                    }
                }else{
                    echo 'fail: id no puede estar vacio!';
                }
                break;
            case 'editar':
                break;
            default:
                echo 'Fail';
                break;
        }
    }
?>