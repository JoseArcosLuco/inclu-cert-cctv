<?php
    require_once('Database.class.php');

    class Camaras{
        public static function create_camaras($idplantas,$name){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_camaras (id_plantas,nombre,estado)
                VALUES(:name, 0)');
            $stmt->bindParam(':idplantas',$idplantas);
            $stmt->bindParam(':name',$name);
            if($stmt->execute()){
                header('HTTP/1.1 201 Camaras creado correctamente');
            } else {
                header('HTTP/1.1 404 Camaras no se ha creado correctamente');
            }
        }

        public static function delete_camaras_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM cctv_camaras WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                header('HTTP/1.1 201 Camaras borrado correctamente');
            } else {
                header('HTTP/1.1 404 Camaras no se ha podido borrar correctamente');
            }
        }

        public static function get_all_camaras($idplantas){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_camaras WHERE id_plantas=:idplantas');
            $stmt->bindParam(':idplantas',$idplantas);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                header('HTTP/1.1 201 OK');
            } else {
                header('HTTP/1.1 404 No se ha podido consultar los camaras');
            }
        }

        public static function get_camaras_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_camaras WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                header('HTTP/1.1 201 OK');
            } else {
                header('HTTP/1.1 404 No se ha podido consultar las camaras');
            }
        }

        public static function update_camaras($id, $idplantas, $name, $estado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_camaras SET id_plantas=:idplantas, nombre=:name, estado=:estado WHERE id=:id');
            $stmt->bindParam(':idplantas',$idplantas);
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':id',$id);

            if($stmt->execute()){
                header('HTTP/1.1 201 Camaras actualizado correctamente');
            } else {
                header('HTTP/1.1 404 Camaras no se ha podido actualizar correctamente');
            }

        }
    }

?>