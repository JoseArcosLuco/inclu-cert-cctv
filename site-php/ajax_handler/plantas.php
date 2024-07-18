<?php
require_once('../includes/Plantas.class.php');
require_once('../includes/Comunas.class.php');
header('Content-Type: application/json');

if (isset($_POST)) {
    $action = $_POST['action'];

    switch ($action) {

        case 'get_comuna':
            $id_ciudad = $_POST['id_ciudad'];
            $comunas = Comunas::get_all_comunas($id_ciudad);
            echo json_encode($comunas);
            break;

        case 'create_planta':
            $idComuna = $_POST['id_comuna'];
            $idComisaria = $_POST['id_comisarias'];
            $idTipoPlanta = $_POST['id_tipo_planta'];
            $grupo = $_POST['grupo'];
            $nombre = $_POST['nombre'];
            $direccion = $_POST['ubicacion'];
            $nombreEncargado = $_POST['encargado_contacto'];
            $emailEncargado = $_POST['encargado_email'];
            $telEncargado = $_POST['encargado_telefono'];
            $mapa = $_POST['mapa'];
            $estado = $_POST['estado'];

            $response = Plantas::create_plantas($idComuna, $idComisaria, $idTipoPlanta, $nombre, $grupo, $direccion,$nombreEncargado,$emailEncargado,$telEncargado,$mapa, $estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_plantas WHERE nombre = :nombre');
                $stmt->bindParam(':nombre', $nombre);
                $stmt->execute();
                $newPlanta = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['planta'] = $newPlanta;
            }

            echo json_encode($response);
            break;
        
        case 'get_plantas':
            $response = Plantas::get_all_plantas();
            echo json_encode($response);
            break;

        case 'edit_planta':
            $id = $_POST['id'];
            $idComuna = $_POST['id_comuna'];
            $idComisaria = $_POST['id_comisarias'];
            $idTipoPlanta = $_POST['id_tipo_planta'];
            $grupo = $_POST['grupo'];
            $nombre = $_POST['nombre'];
            $direccion = $_POST['ubicacion'];
            $nombreEncargado = $_POST['encargado_contacto'];
            $emailEncargado = $_POST['encargado_email'];
            $telEncargado = $_POST['encargado_telefono'];
            $mapa = $_POST['mapa'];
            $estado = $_POST['estado'];

            $response = Plantas::update_plantas($id,$idComuna, $idComisaria, $idTipoPlanta, $nombre, $grupo, $direccion,$nombreEncargado,$emailEncargado,$telEncargado,$mapa, $estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_plantas WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $updatedPlanta = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['planta'] = $updatedPlanta;
            }

            echo json_encode($response);
            break;

        case 'delete_planta':
            $id = $_POST['id'];
            $response = Plantas::delete_plantas_by_id($id);
            echo json_encode($response);
            break;
        // Otros casos para update, delete, etc.
    }
}
?>