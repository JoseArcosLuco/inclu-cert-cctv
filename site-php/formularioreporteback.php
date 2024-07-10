<?php 
    include("./includes/Database.class.php");

    if(isset($_POST['acciones'])){
        
        isset($_POST['id_aux']) ? $id = trim($_POST['id_aux']) : $id = '';
        isset($_POST['id_planta']) ? $idplanta = trim($_POST['id_planta']) : $idplanta = '';
        isset($_POST['id_turno']) ? $idturno = trim($_POST['id_turno']) : $idturno = '';
        isset($_POST['nombre']) ? $nombre = trim($_POST['nombre']) : $nombre = '';
        isset($_POST['estado']) ? $estado = trim($_POST['estado']) : $estado = '';
        isset($_POST['acciones']) ? $acciones = trim($_POST['acciones']) : $acciones = '';

        switch($acciones){ 
            
            case 'grabarreporte':
                if(!empty($id)){
                    try {
                        $salida ="";
                        $database = new Database();
                        $conn = $database->getConnection();
                        $stmt = $conn->prepare('SELECT id, nombre FROM cctv_turnos WHERE id_plantas = :idplanta and id_jornada = :id and estado=1');
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->bindParam(':idplanta', $idplanta, PDO::PARAM_INT);
                        if($stmt->execute()){
                            $result = $stmt->fetchAll();
                            $rows = $stmt->rowCount();
                            $salida = '<option value="">Seleccione</option>';
                            if($rows>0){
                                foreach($result as $row){
                                   $salida = $salida . '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
                                }
                            }else{
                                $salida = '<option value="">Seleccione</option>';
                            }
                        }

                        echo $salida;

                    } catch(Exception $e) {
                        echo'fail'. $e->getMessage() .'';
                    }
                }else{
                    echo 'fail: id no puede estar vacio!';
                }
                break;

            case 'buscarturnos':
                if(!empty($id)){
                    try {
                        $salida ="";
                        $database = new Database();
                        $conn = $database->getConnection();
                        $stmt = $conn->prepare('SELECT id, nombre FROM cctv_turnos WHERE id_plantas = :idplanta and id_jornada = :id and estado=1');
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->bindParam(':idplanta', $idplanta, PDO::PARAM_INT);
                        if($stmt->execute()){
                            $result = $stmt->fetchAll();
                            $rows = $stmt->rowCount();
                            $salida = '<option value="">Seleccione</option>';
                            if($rows>0){
                                foreach($result as $row){
                                   $salida = $salida . '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
                                }
                            }else{
                                $salida = '<option value="">Seleccione</option>';
                            }
                        }

                        echo $salida;

                    } catch(Exception $e) {
                        echo'fail'. $e->getMessage() .'';
                    }
                }else{
                    echo 'fail: id no puede estar vacio!';
                }
                break;
            case 'buscarresponsables':
                    if(!empty($idplanta) && !empty($idturno)){
                        try {
                            $salida ="";
                            $database = new Database();
                            $conn = $database->getConnection();
                            $stmt = $conn->prepare('SELECT u.id,concat(u.nombres, " ", u.apellidos," ",pe.nombre) as nombre FROM cctv_operadores as o inner join cctv_users as u on u.id = o.id_users inner join cctv_perfil as pe on u.id_perfil = pe.id inner join cctv_turnos as t on o.id_turnos = t.id inner join cctv_plantas as pl on t.id_plantas = pl.id WHERE pl.id=:idplanta and t.id=:idturno and o.estado=1 and u.estado=1 and pe.estado =1 and t.estado=1 and pl.estado=1');
                            $stmt->bindParam(':idplanta', $idplanta, PDO::PARAM_INT);
                            $stmt->bindParam(':idturno', $idturno, PDO::PARAM_INT);
                            if($stmt->execute()){
                                $result = $stmt->fetchAll();
                                $rows = $stmt->rowCount();
                                $salida = '<option value="">Seleccione</option>';
                                if($rows>0){
                                    foreach($result as $row){
                                       $salida = $salida . '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
                                    }
                                }else{
                                    $salida = '<option value="">Seleccione</option>';
                                }
                            }
    
                            echo $salida;
    
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