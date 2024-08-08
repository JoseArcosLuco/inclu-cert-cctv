<?php
require_once('../includes/TipoPlanta.class.php');

header('Content-Type: application/json');

if (isset($_POST)) {
    $action = $_POST['action'];

    switch ($action) {
        case 'create_':
            
            $nombres = $_POST['nombres'];
            $estado = $_POST['estado'];

            $response = TipoPlanta::create_tipo_planta($nombres, $estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_tipo_planta WHERE nombre = :nombre');
                $stmt->bindParam(':nombre', $nombres);
                $stmt->execute();
                $newData = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['row'] = $newData;
            }

            echo json_encode($response);
            break;
        
        case 'get_tipoplanta':
            $response = TipoPlanta::get_all_tipo_planta();
            echo json_encode($response);
            break;

        case 'edit_':
            $id = $_POST['id'];
            $nombres = $_POST['nombres'];
            $estado = $_POST['estado'];

            $response = TipoPlanta::update_tipo_planta($id, $nombres, $estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_tipo_planta WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $updatedNewData = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['row'] = $updatedNewData;
            }

            echo json_encode($response);
            break;

        case 'delete_':
            $id = $_POST['id'];
            $response = TipoPlanta::delete_tipo_planta_by_id($id);

            if (!$response['status'] && isset($response['plantas'])) {
                $response['plantas'] = $response['plantas'];
            }

            echo json_encode($response);
            break;
        // Otros casos para update, delete, etc.
    }
}
?>