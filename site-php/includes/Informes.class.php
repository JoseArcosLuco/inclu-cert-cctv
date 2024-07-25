<?php
    require_once('Database.class.php');

    class Informes{
        
        public static function get_client_by_plant_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT id_clientes FROM cctv_plantas WHERE id = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_cliente = $result['id_clientes'];
            $stmt = $conn->prepare('SELECT * FROM cctv_clientes WHERE id = :id_cliente');
            $stmt->bindParam(':id_cliente', $id_cliente);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        public static function get_plantas_by_informe_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT id_plantas FROM cctv_gestion_plantas WHERE id = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_planta = $result['id_plantas'];
            $stmt = $conn->prepare('SELECT * FROM cctv_plantas WHERE id = :id_planta');
            $stmt->bindParam(':id_planta', $id_planta);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        public static function get_informe($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_gestion_plantas WHERE id = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }
    }

?>