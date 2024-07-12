<?php
require_once('../includes/Users.class.php');

if (isset($_POST)) {
    $action = $_POST['action'];
    header('Content-Type: application/json');

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

        // Otros casos para update, delete, etc.
    }
}
?>