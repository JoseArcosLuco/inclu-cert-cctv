<?php
require_once('../includes/Turnos.class.php');
header('Content-Type: application/json');

if (isset($_POST)) {
    $action = $_POST['action'];

    switch ($action) {

        case 'create_turno':
            
            $nombre = $_POST['nombre'];
            $id_plantas = $_POST['id_plantas'];
            $id_jornada = $_POST['id_jornada'];
            $estado = $_POST['estado'];

            $response = Turnos::create_turno($nombre,$id_plantas,$id_jornada,$estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_turnos WHERE nombre = :nombre');
                $stmt->bindParam(':nombre', $nombre);
                $stmt->execute();
                $newTurno = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['turno'] = $newTurno;
            }

            echo json_encode($response);
            break;
        
        case 'get_turnos':
            $response = Turnos::get_all_turnos();
            echo json_encode($response);
            break;

        case 'edit_turno':
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $id_plantas = $_POST['id_plantas'];
            $id_jornada = $_POST['id_jornada'];
            $estado = $_POST['estado'];

            $response = Turnos::update_turnos($id, $nombre, $id_plantas, $id_jornada, $estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_turnos WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $updatedTurno = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['turno'] = $updatedTurno;
            }

            echo json_encode($response);
            break;

        case 'delete_turno':
            $id = $_POST['id'];
            $response = Turnos::delete_turno($id);
            echo json_encode($response);
            break;
    }
}
?>