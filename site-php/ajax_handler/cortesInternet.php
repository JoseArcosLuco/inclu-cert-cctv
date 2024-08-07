<?php
require_once('../includes/CortesInternet.class.php');
header('Content-Type: application/json');

if (isset($_POST)) {
    $action = $_POST['action'];

    switch ($action) {

        case 'create_reporte':
            $idPlanta = $_POST['id_planta'];
            $idCliente = $_POST['id_cliente'];
            $idUsuario = $_POST['id_usuario'];
            $fecha = $_POST['fecha'] . ' ' . $_POST['hora'];
            $observacion = $_POST['observacion'];
            $estado = $_POST['estado'];

            $response = CortesInternet::create_corteInternet($idPlanta, $idCliente,$fecha, $observacion, $estado, $idUsuario);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_reporte_corte_internet WHERE fecha = :fecha');
                $stmt->bindParam(':fecha', $fecha);
                $stmt->execute();
                $newReporte = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['reporte'] = $newReporte;
            }

            echo json_encode($response);
            break;

        case 'get_plantas':
            $id = $_POST['id'];
            $response = CortesInternet::get_all_plantas($id);
            echo json_encode($response);
            break;
        
        case 'get_reporte':
            $response = CortesInternet::get_all_corteInternet();
            echo json_encode($response);
            break;

        case 'edit_reporte':
            $id = $_POST['id'];
            $fecha = $_POST['fecha'] . ' ' . $_POST['hora'];
            $observacion = $_POST['observacion'];
            $estado = $_POST['estado'];

            $response = CortesInternet::update_corteInternet($id,$fecha, $observacion, $estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_reporte_corte_internet WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $updatedReporte = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['reporte'] = $updatedReporte;
            }

            echo json_encode($response);
            break;

        case 'delete_reporte':
            $id = $_POST['id'];
            $response = CortesInternet::delete_corteInternet_by_id($id);
            echo json_encode($response);
            break;
        // Otros casos para update, delete, etc.
    }
}
?>