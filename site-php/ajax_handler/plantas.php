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
            $idCLiente = $_POST['id_clientes'];
            $direccion = $_POST['ubicacion'];
            $nombreEncargado = $_POST['encargado_contacto'];
            $emailEncargado = $_POST['encargado_email'];
            $telEncargado = $_POST['encargado_telefono'];
            $mapa = $_POST['mapa'];
            $estado = $_POST['estado'];
            $marcaDispositivos = $_POST['marcaDispositivos'] ?? null;
            $modelosDispositivos = $_POST['modelosDispositivos'] ?? null;
            $cantidadCamaras = $_POST['cantidadCamaras'] ?? null;
            $modeloCamaras = $_POST['modeloCamaras'] ?? null;
            $codificacionCamaras = $_POST['codificacionCamaras'] ?? null;
            $analiticas = $_POST['analiticas'] ?? null;
            $sensores = $_POST['sensores'] ?? null;
            $tamanoGrabacion = $_POST['tamanoGrabacion'] ?? null;
            $diasGrabacion = $_POST['diasGrabacion'] ?? null;
            $alarmaVoceo = $_POST['alarmaVoceo'] ?? null;
            $sirenas = $_POST['sirenas'] ?? null;
            $internet = $_POST['internet'] ?? null;
            $proveedorInternet = $_POST['proveedorInternet'] ?? null;
            $p2p = $_POST['p2p'] ?? null;
            $autoregistro = $_POST['autoregistro'] ?? null;

            $response = Plantas::create_plantas($idComuna, $idComisaria, $idTipoPlanta, $idCLiente,$nombre, $grupo, $direccion,$nombreEncargado,$emailEncargado,$telEncargado,$mapa, $estado, $marcaDispositivos, 
            $modelosDispositivos, $cantidadCamaras, $modeloCamaras, $codificacionCamaras, $analiticas, $sensores, $tamanoGrabacion, $diasGrabacion, $alarmaVoceo, $sirenas, $internet, $proveedorInternet, $p2p, $autoregistro);
            
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

        case 'get_plantas_short_data':
            $response = Plantas::get_all_plantas_short_data();
            echo json_encode($response);
            break;

        case 'get_plantas_by_id':
            $id = $_POST['id'];
            $response = Plantas::get_plantas_by_id($id);
            echo json_encode($response);
            break;

        case 'edit_planta':
            $id = $_POST['id'];
            $idComuna = $_POST['id_comuna'];
            $idComisaria = $_POST['id_comisarias'];
            $idTipoPlanta = $_POST['id_tipo_planta'];
            $idCLiente = $_POST['id_clientes'];
            $grupo = $_POST['grupo'];
            $nombre = $_POST['nombre'];
            $direccion = $_POST['ubicacion'];
            $nombreEncargado = $_POST['encargado_contacto'];
            $emailEncargado = $_POST['encargado_email'];
            $telEncargado = $_POST['encargado_telefono'];
            $mapa = $_POST['mapa'];
            $estado = $_POST['estado'];

            $response = Plantas::update_plantas($id,$idComuna, $idComisaria, $idTipoPlanta,$idCLiente,$nombre, $grupo, $direccion,$nombreEncargado,$emailEncargado,$telEncargado,$mapa, $estado);
            
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