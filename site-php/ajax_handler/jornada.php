<?php
require_once('../includes/Jornada.class.php');
header('Content-Type: application/json');

if (isset($_POST)) {
    $action = $_POST['action'];

    switch ($action) {
        case 'create_':
            
            $nombre = $_POST['nombre'];
            $estado = $_POST['estado'];

            $response = Jornada::create_jornada($nombre, $estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_jornada WHERE nombre = :nombre');
                $stmt->bindParam(':nombre', $nombre);
                $stmt->execute();
                $newData = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['row'] = $newData;
            }

            echo json_encode($response);
            break;
        
        case 'get_jornada':
            $response = Jornada::get_all_jornadas();
            echo json_encode($response);
            break;

        case 'edit_':
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $estado = $_POST['estado'];

            $response = Jornada::update_jornada($id, $nombre, $estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_jornada WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $updatedNewData = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['row'] = $updatedNewData;
            }

            echo json_encode($response);
            break;

        case 'delete_':
            $id = $_POST['id'];
            $response = Jornada::delete_jornada_by_id($id);

            if (!$response['status'] && isset($response['turnos'])) {
                $response['turnos'] = $response['turnos'];
            }

            echo json_encode($response);
            break;
        // Otros casos para update, delete, etc.
    }
}
?>