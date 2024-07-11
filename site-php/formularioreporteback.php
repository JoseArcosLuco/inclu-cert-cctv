<?php 
    session_start();
    date_default_timezone_set("America/Santiago");
    include("./includes/Database.class.php");

    if(isset($_POST['acciones'])){
        
        isset($_POST['id_aux']) ? $id = trim($_POST['id_aux']) : $id = '';
        
        
        isset($_SESSION["iduser"]) ? $iduser = trim($_SESSION["iduser"]) : $iduser = '';;
        isset($_POST['fecha']) ? $fecha = trim($_POST['fecha']) : $fecha = '';
        isset($_POST['planta']) ? $idplantas = trim($_POST['planta']) : $idplantas = '';
        isset($_POST['plantaenlinea']) ? $plantaenlinea = trim($_POST['plantaenlinea']) : $plantaenlinea = '';
        isset($_POST['conintermitencia']) ? $conintermitencia = trim($_POST['conintermitencia']) : $conintermitencia = '';
        isset($_POST['camarassinconexion']) ? $camarassinconexion = trim($_POST['camarassinconexion']) : $camarassinconexion = '';
        isset($_POST['camarastotales']) ? $camarastotales = trim($_POST['camarastotales']) : $camarastotales = '';
        isset($_POST['porcentajecamaraoperativa']) ? $porcentajecamaraoperativa = trim($_POST['porcentajecamaraoperativa']) : $porcentajecamaraoperativa = '';

        isset($_POST['jornada']) ? $jornada = trim($_POST['jornada']) : $jornada = '';
        isset($_POST['turno']) ? $turno = trim($_POST['turno']) : $turno = '';
        isset($_POST['horario']) ? $horario = trim($_POST['horario']) : $horario = '';
        isset($_POST['responsable']) ? $responsable = trim($_POST['responsable']) : $responsable = '';
        isset($_POST['planta_sin_conexion']) ? $planta_sin_conexion = trim($_POST['planta_sin_conexion']) : $planta_sin_conexion = '';
        isset($_POST['obs_turno']) ? $obs_turno = trim($_POST['obs_turno']) : $obs_turno = '';

        isset($_POST['id_planta']) ? $idplanta = trim($_POST['id_planta']) : $idplanta = '';
        isset($_POST['id_turno']) ? $idturno = trim($_POST['id_turno']) : $idturno = '';
        isset($_POST['nombre']) ? $nombre = trim($_POST['nombre']) : $nombre = '';
        isset($_POST['estado']) ? $estado = trim($_POST['estado']) : $estado = '';
        isset($_POST['acciones']) ? $acciones = trim($_POST['acciones']) : $acciones = '';

        switch($acciones){ 
            
            case 'grabarreporte':
                if(!empty($iduser)){
                    try {
                        $salida ="";
                        $fecharegistro = date("Y-m-d H:i:s");

                        if (empty($fecha)){$fecha = $fecharegistro;}

                        $database = new Database();
                        $conn = $database->getConnection();
                        $stmt = $conn->prepare('INSERT INTO cctv_gestion_plantas (id_users,id_plantas,id_turno,id_responsable,horario,planta_en_linea,con_intermitencia,camaras_sin_conexion,camaras_totales,porcentaje_camara_operativa,observaciones,fecha_gestion,fecha_registro,estado) VALUES (:idusers,:idplantas,:idturno,:idresponsable,:horario,:plantaenlinea,:conintermitencia,:camarassinconexion,:camarastotales,:porcentajecamaraoperativa,:observaciones,:fecha_gestion,:fecha_registro, 0)');
                        $stmt->bindParam(':idusers',$iduser);
                        $stmt->bindParam(':idplantas',$idplantas);
                        $stmt->bindParam(':idturno',$turno);
                        $stmt->bindParam(':idresponsable',$responsable);
                        $stmt->bindParam(':horario',$horario);
                        $stmt->bindParam(':plantaenlinea',$planta_sin_conexion);
                        $stmt->bindParam(':conintermitencia',$conintermitencia);
                        $stmt->bindParam(':camarassinconexion',$camarassinconexion);
                        $stmt->bindParam(':camarastotales',$camarastotales);
                        $stmt->bindParam(':porcentajecamaraoperativa',$porcentajecamaraoperativa);
                        $stmt->bindParam(':observaciones',$obs_turno);
                        $stmt->bindParam(':fecha_gestion',$fecha);
                        $stmt->bindParam(':fecha_registro',$fecharegistro);
                        
                        if($stmt->execute()){
                            $idInsertado = $conn->lastInsertId();
                            $salida = '<div class="alert alert-success">Reporte Ingresado Exitosamente! Su numero reporte es: '.$idInsertado.'</div>';
                        }

                        echo $salida;

                    } catch(Exception $e) {
                        echo '<div class="alert alert-danger">fail:'. $e->getMessage() .'</div>';
                    }
                }else{
                    echo '<div class="alert alert-danger">fail: id usuario no puede estar vacio!</div>';
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