<?php
require_once('../includes/Perfil.class.php');
header('Content-Type: application/json');

if (isset($_POST)) {
    $action = $_POST['action'];

    switch ($action) {

        case 'create_perfil':
            $nombre = $_POST['nombre'];
            $estado = $_POST['estado'];

            $response = Perfil::create_perfil($nombre, $estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_perfil WHERE nombre = :nombre');
                $stmt->bindParam(':nombre', $nombre);
                $stmt->execute();
                $newPerfil = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['perfil'] = $newPerfil;
            }

            echo json_encode($response);
            break;
        
        case 'get_perfiles':
            $response = Perfil::get_all_perfiles();
            echo json_encode($response);
            break;

        case 'edit_perfil':
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $estado = $_POST['estado'];

            $response = Perfil::update_perfil($id, $nombre, $estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_perfil WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $updatedPerfil = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['perfil'] = $updatedPerfil;
            }

            echo json_encode($response);
            break;

        case 'delete_perfil':
            $id = $_POST['id'];
            $response = Perfil::delete_perfil_by_id($id);
            echo json_encode($response);
            break;
        // Otros casos para update, delete, etc.
    }
}
?>