<?php
require_once('../includes/Database.class.php');
header('Content-Type: application/json');

if (isset($_POST)) {
    $action = $_POST['action'];

    switch ($action) {

        case 'aprobar_informe':
            $id = $_POST['id'];

            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('UPDATE cctv_gestion_plantas SET estado = 1 WHERE id = :id');
            $stmt->bindParam(':id', $id);
            
            if ($stmt->execute()) {
                echo json_encode(['status' => true, 'message' => 'Reporte aprobado correctamente']);
            } else {
                echo json_encode(['status' => false, 'message' => 'El Reporte '.$id.' no se ha podido aprobado correctamente']);
            }
            break;
        case 'desaprobar_informe':
            $id = $_POST['id'];

            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('UPDATE cctv_gestion_plantas SET estado = 0 WHERE id = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            if ($stmt->execute()) {
                echo json_encode(['status' => true, 'message' => 'Reporte desaprobado correctamente']);
            } else {
                echo json_encode(['status' => false, 'message' => 'El Reporte '.$id.' no se ha podido desaprobar correctamente']);
            }
            break;
    }
}
?>