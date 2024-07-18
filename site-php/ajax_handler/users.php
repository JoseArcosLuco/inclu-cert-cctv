<?php
require_once('../includes/Users.class.php');
header('Content-Type: application/json');


if (isset($_POST)) {
    $action = $_POST['action'];

    switch ($action) {
        case 'create_user':
            $idperfil = $_POST['id_perfil'];
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $estado = $_POST['estado'];
            $codigogoogle2fa = '';

            $response = Users::create_users($idperfil, $nombres, $apellidos, $email, $password, $codigogoogle2fa, $estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_users WHERE email = :email');
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $newUser = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['user'] = $newUser;
            }

            echo json_encode($response);
            break;
        
        case 'get_users':
            $response = Users::get_all_users();
            echo json_encode($response);
            break;

        case 'edit_user':
            $id = $_POST['id'];
            $idperfil = $_POST['id_perfil'];
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $estado = $_POST['estado'];
            $codigogoogle2fa = '';
            $response = Users::update_users($id, $idperfil, $nombres, $apellidos, $email, $password, $codigogoogle2fa, $estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_users WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $updatedUser = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['user'] = $updatedUser;
            }

            echo json_encode($response);
            break;

        case 'delete_user':
            $id = $_POST['id'];
            $response = Users::delete_users_by_id($id);
            echo json_encode($response);
            break;
        // Otros casos para update, delete, etc.
    }
}
?>