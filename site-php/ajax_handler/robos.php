<?php
require_once('../includes/Robos.class.php');
header('Content-Type: application/json');

if (isset($_POST)) {
    $action = $_POST['action'];

    switch ($action) {

        case 'create_reporte':
            $idPlanta = $_POST['id_planta'];
            $idCliente = $_POST['id_cliente'];
            $idUsuario = $_POST['id_usuario'];
            $fecha = $_POST['fecha'] . ' ' . $_POST['hora'];
            $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] . ' ' . $_POST['hora_fin'] : null;
            $observacion = $_POST['observacion'];
            $estado = $_POST['estado'];

            $response = Robos::create_robo($idPlanta, $idCliente,$fecha, $fecha_fin, $observacion, $estado, $idUsuario);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_reporte_robo WHERE fecha = :fecha');
                $stmt->bindParam(':fecha', $fecha);
                $stmt->execute();
                $newRobo = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['reporte'] = $newRobo;
            }

            echo json_encode($response);
            break;

        case 'get_plantas':
            $id = $_POST['id'];
            $response = Robos::get_all_plantas($id);
            echo json_encode($response);
            break;
        
        case 'get_reporte':
            $response = Robos::get_all_robos();
            echo json_encode($response);
            break;

        case 'edit_reporte':
            $id = $_POST['id'];
            $fecha = $_POST['fecha'] . ' ' . $_POST['hora'];
            $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] . ' ' . $_POST['hora_fin'] : null;
            $observacion = $_POST['observacion'];
            $estado = $_POST['estado'];

            $response = Robos::update_robos($id,$fecha, $fecha_fin,$observacion, $estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_reporte_robo WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $updatedReporte = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['reporte'] = $updatedReporte;
            }

            echo json_encode($response);
            break;

        case 'delete_reporte':
            $id = $_POST['id'];
            $response = Robos::delete_robo_by_id($id);
            echo json_encode($response);
            break;
        // Otros casos para update, delete, etc.
    }
}
?>