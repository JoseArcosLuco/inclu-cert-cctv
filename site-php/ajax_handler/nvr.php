<?php
require_once('../includes/nvr.class.php');
header('Content-Type: application/json');

if (isset($_POST)) {
    $action = $_POST['action'];

    switch ($action) {

        case 'create_nvr':
            $idPlanta = $_POST['id_planta'];
            $numDispositivo = $_POST['num_dispositivo'];
            $serial = $_POST['serial'];
            $estado = $_POST['estado'];

            $response = NVR::create_nvr($idPlanta, $numDispositivo, $serial,$estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_nvr WHERE numero_dispositivo=:num_dispositivo AND serial=:serial');
                $stmt->bindParam(':num_dispositivo', $numDispositivo);
                $stmt->bindParam(':serial', $serial);
                $stmt->execute();
                $newNVR = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['nvr'] = $newNVR;
            }

            echo json_encode($response);
            break;

        case 'get_plantas':
            $id = $_POST['id'];
            $response = CortesInternet::get_all_plantas($id);
            echo json_encode($response);
            break;
        
        case 'get_nvr':
            $id = $_POST['id'];
            $response = NVR::get_all_nvr($id);
            echo json_encode($response);
            break;

        case 'edit_reporte':
            $id = $_POST['id'];
            $fecha = $_POST['fecha'] . ' ' . $_POST['hora'];
            $fecha_fin = isset($_POST['fecha_fin']) ? $_POST['fecha_fin'] . ' ' . $_POST['hora_fin'] : null;
            $observacion = $_POST['observacion'];
            $estado = $_POST['estado'];

            $response = CortesInternet::update_corteInternet($id,$fecha,$fecha_fin,$observacion, $estado);
            
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