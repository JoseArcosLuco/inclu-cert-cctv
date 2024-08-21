<?php
require_once('../includes/Operadores.class.php');
header('Content-Type: application/json');

if (isset($_POST)) {
    $action = $_POST['action'];

    switch ($action) {

        case 'create_operador':
            $id_user = $_POST['id_user'];
            $id_turno = $_POST['id_turno'];

            $response = Operadores::create_operadores($id_user, $id_turno);

            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_operadores WHERE id_users=:id_user');
                $stmt->bindParam(':id_user', $id_user);
                $stmt->execute();
                $newOperador = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['operador'] = $newOperador;
            }

            echo json_encode($response);
            break;

        case 'get_operadores':
            $id = $_POST['id'];
            $response = Operadores::get_all_operadores($id);
            echo json_encode($response);
            break;

        case 'search_operadores':
            $search = $_POST['search'];

            $unasigned_users = Operadores::get_all_unasigned_users();

            $filtered_users = array_filter($unasigned_users, function ($user) use ($search) {
                return stripos($user['nombres'] . ' ' . $user['apellidos'], $search) !== false;
            });

            echo json_encode($filtered_users);
            break;

        case 'delete_operador':
            $id = $_POST['id'];
            $id_user = $_POST['id_user'];
            $response = Operadores::delete_operadores_by_id($id);
            echo json_encode($response);
            break;
            // Otros casos para update, delete, etc.
    }
}
