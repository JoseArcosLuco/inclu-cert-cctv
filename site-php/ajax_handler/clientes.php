<?php
require_once('../includes/Clientes.class.php');
header('Content-Type: application/json');


if (isset($_POST)) {
    $action = $_POST['action'];

    switch ($action) {
        case 'create_':
            
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $fecha_contrato = $_POST['fecha_contrato'];
            $contacto = $_POST['contacto'];
            $estado = $_POST['estado'];
            

            $response = Clientes::create_cliente($nombre, $email, $fecha_contrato, $contacto, $estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_clientes WHERE nombre = :nombre');
                $stmt->bindParam(':nombre', $nombre);
                $stmt->execute();
                $newUser = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['row'] = $newUser;
            }

            echo json_encode($response);
            break;
        
        case 'get_clientes':
            $response = Clientes::get_all_clients();
            echo json_encode($response);
            break;

        case 'edit_':
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $fecha_contrato = $_POST['fecha_contrato'];
            $contacto = $_POST['contacto'];
            $estado = $_POST['estado'];
            $response = Clientes::update_cliente($id, $nombre, $email, $fecha_contrato, $contacto, $estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_clientes WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $updatedUser = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['row'] = $updatedUser;
            }

            echo json_encode($response);
            break;

        case 'delete_':
            $id = $_POST['id'];
            $response = Clientes::delete_client_by_id($id);

            echo json_encode($response);
            break;
        // Otros casos para update, delete, etc.
    }
}
?>