<?php
require_once('../includes/Reportes.class.php');
header('Content-Type: application/json');

date_default_timezone_set('America/Santiago');

if (isset($_POST)) {
    $action = $_POST['action'];

    switch ($action) {

        case 'create_reporte':
            $idCliente = $_POST['id_cliente'];
            $idPlanta = $_POST['id_planta'];
            $idOperador = $_POST['id_operador'];
            $fecha = date('Y-m-d');
            $camaras = $_POST['camaras'];
            $camarasOnline = $_POST['camaras_online'];
            $canal = $_POST['canal'];
            $observacion = $_POST['observacion'];
            $response = Reportes::create_reporte($idCliente, $idPlanta, $idOperador,$fecha, $camaras, $camarasOnline, $canal, $observacion);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_reporte_diario WHERE id_operador = :id_operador AND id_cliente = :id_cliente AND id_planta = :id_planta AND fecha = :fecha AND canal = :canal AND observacion = :observacion AND camaras = :camaras AND camaras_online = :camaras_online');
                $stmt->bindParam(':id_cliente', $idCliente);
                $stmt->bindParam(':id_operador', $idOperador);
                $stmt->bindParam(':id_planta', $idPlanta);
                $stmt->bindParam(':fecha', $fecha);
                $stmt->bindParam(':canal', $canal);
                $stmt->bindParam(':observacion', $observacion);
                $stmt->bindParam(':camaras', $camaras);
                $stmt->bindParam(':camaras_online', $camarasOnline);
                $stmt->execute();
                $newReporte = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['reporte'] = $newReporte;
            }

            echo json_encode($response);
            break;

        case 'count_camaras_planta':
            $id_planta = $_POST['id_planta'];
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT COUNT(id) as total FROM cctv_camaras WHERE id_plantas = :id_plantas');
            $stmt->bindParam(':id_plantas', $id_planta);
            $stmt->execute();
            $response = $stmt->fetch(PDO::FETCH_ASSOC);

            echo json_encode($response);
            break;

        case 'get_plantas':
            $id_cliente = $_POST['id_cliente'];
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_plantas WHERE id_clientes = :id_cliente');
            $stmt->bindParam(':id_cliente', $id_cliente);
            $stmt->execute();
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($response);
            break;

        case 'get_reportes':
            $response = Reportes::get_all_reportes();
            echo json_encode($response);
            break;

        case 'edit_reporte':
            $id = $_POST['id'];
            $idPlanta = $_POST['id_planta'];
            $nombre = $_POST['nombre'];
            $estado = $_POST['estado'];

            $response = Camaras::update_camaras($id,$idPlanta, $nombre, $estado);
            
            if ($response['status']) {
                $database = new Database();
                $conn = $database->getConnection();
                $stmt = $conn->prepare('SELECT * FROM cctv_camaras WHERE id = :id');
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $updatedCamara = $stmt->fetch(PDO::FETCH_ASSOC);
                $response['camara'] = $updatedCamara;
            }

            echo json_encode($response);
            break;

        case 'delete_reporte':
            $id = $_POST['id'];
            $response = Camaras::delete_camaras_by_id($id);
            echo json_encode($response);
            break;

        case 'get_reportes_by_cliente':
            $id_cliente = $_POST['id'];
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_reporte_diario WHERE id_clientes = :id_cliente');
            $stmt->bindParam(':id_cliente', $id_cliente);
            $stmt->execute();
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($response);
            break;
        
    }

}
?>