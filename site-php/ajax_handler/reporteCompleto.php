<?php
    include("../includes/Database.class.php");

    if (isset($_POST)) {
        $action = $_POST['action'];

        switch($action){

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
            
            case 'get_plantas_camaras':
                $id_plantas = $_POST['id_plantas'];
                $database = new Database();
                $conn = $database->getConnection();
                $sql = '
                SELECT cam.*,
                GROUP_CONCAT(op.id_users) as operador
                FROM cctv_camaras cam
                LEFT JOIN cctv_plantas p ON cam.id_plantas = p.id
                LEFT JOIN cctv_turnos t ON p.id_clientes = t.id
                LEFT JOIN cctv_operadores op ON t.id = op.id_turnos
                WHERE cam.id_plantas = :id_plantas AND op.estado = 1
                GROUP BY cam.id;';
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id_plantas', $id_plantas);
                $stmt->execute();
                $response = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo json_encode($response);
                break;

            default:
                echo 'Fail';
                break;
        }
    }
?>