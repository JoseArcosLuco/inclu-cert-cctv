<?php
require_once('../includes/Comisarias.class.php');
header('Content-Type: application/json');

if (isset($_POST)) {
    $action = $_POST['action'];

    switch ($action) {
        case 'create_':
            
            $nombres = $_POST['nombres'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $movil = $_POST['movil'];
            $estado = $_POST['estado'];

            $response = Comisarias::create_comisarias($nombres, $direccion, $telefono, $movil, $estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_comisarias WHERE nombre = :nombre');
                $stmt->bindParam(':nombre', $nombres);
                $stmt->execute();
                $newData = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['row'] = $newData;
            }

            echo json_encode($response);
            break;
        
        case 'get_comisaria':
            $response = Comisarias::get_all_comisarias();
            echo json_encode($response);
            break;

        case 'edit_':
            $id = $_POST['id'];
            $nombres = $_POST['nombres'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $movil = $_POST['movil'];
            $estado = $_POST['estado'];

            $response = Comisarias::update_comisarias($id, $nombres, $direccion, $telefono, $movil, $estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_comisarias WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $updatedNewData = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['row'] = $updatedNewData;
            }

            echo json_encode($response);
            break;

        case 'delete_':
            $id = $_POST['id'];
            $response = Comisarias::delete_comisarias_by_id($id);
            echo json_encode($response);
            break;
        // Otros casos para update, delete, etc.
    }
}
?>