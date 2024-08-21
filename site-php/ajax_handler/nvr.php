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

        case 'edit_nvr':
            $id = $_POST['id'];
            $numeroDispositivo = $_POST['num_dispositivo'];
            $serial = $_POST['serial'];
            $estado = $_POST['estado'];

            $response = NVR::update_nvr($id, $numeroDispositivo, $serial, $estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_nvr WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $updatedNVR = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['nvr'] = $updatedNVR;
            }

            echo json_encode($response);
            break;

        case 'delete_nvr':
            $id = $_POST['id'];
            $response = NVR::delete_nvr_by_id($id);
            echo json_encode($response);
            break;
        // Otros casos para update, delete, etc.
    }
}
?>