<?php
require_once('../includes/Novedades.class.php');
header('Content-Type: application/json');

if (isset($_POST)) {
    $action = $_POST['action'];

    switch ($action) {

        case 'create_novedades':
            $idPlanta = $_POST['id_planta'];
            $idCliente = $_POST['id_cliente'];
            $idUsuario = $_POST['id_usuario'];
            $fecha = $_POST['fecha'] . ' ' . $_POST['hora'];
            $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] . ' ' . $_POST['hora_fin'] : null;
            $observacion = $_POST['observacion'];
            $estado = $_POST['estado'];

            $response = Novedades::create_novedades($idPlanta, $idCliente, $fecha, $fecha_fin ,$observacion, $estado , $idUsuario);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_reporte_novedades WHERE fecha = :fecha');
                $stmt->bindParam(':fecha', $fecha);
                $stmt->execute();
                $newRobo = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['reporte'] = $newRobo;
            }

            echo json_encode($response);
            break;

        case 'get_plantas':
            $id = $_POST['id'];
            $response = Novedades::get_all_plantas($id);
            echo json_encode($response);
            break;
        
        case 'get_novedades':
            $response = Novedades::get_all_novedades();
            echo json_encode($response);
            break;

        case 'edit_novedades':
            $id = $_POST['id'];
            $fecha = $_POST['fecha'] . ' ' . $_POST['hora'];
            $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] . ' ' . $_POST['hora_fin'] : null;
            $observacion = $_POST['observacion'];
            $estado = $_POST['estado'];

            $response = Novedades::update_novedades($id,$fecha,$fecha_fin, $observacion, $estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_reporte_novedades WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $updatedReporte = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['reporte'] = $updatedReporte;
            }

            echo json_encode($response);
            break;

        case 'delete_novedades':
            $id = $_POST['id'];
            $response = Novedades::delete_novedades_by_id($id);
            echo json_encode($response);
            break;
        // Otros casos para update, delete, etc.
    }
}
?>