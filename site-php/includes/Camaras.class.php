<?php
    require_once('Database.class.php');

    class Camaras{
        public static function create_camaras($idplantas,$nombre,$estado){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_camaras (id_plantas,nombre,estado)
                VALUES(:idplantas ,:nombre, :estado)');
            $stmt->bindParam(':idplantas',$idplantas);
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':estado',$estado);
            if ($stmt->execute()) {
                return [
                    'status' => true,
                    'message' => 'Cámara creada correctamente.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Error al crear la cámara.'
                ];
            }
        }

        public static function delete_camaras_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM cctv_camaras WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                return [
                    'status' => true,
                    'message' => 'Cámara borrado correctamente.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'No se ha podido borrar la Cámara '.$id
                ];
            }
        }

        public static function get_all_camaras($idplantas){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_camaras WHERE id_plantas=:idplantas');
            $stmt->bindParam(':idplantas',$idplantas);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                return $result;
            } else {
                return [];
            }
        }

        public static function get_all_camaras_without_plantaId(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_camaras');
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                return $result;
            } else {
                return [];
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

        public static function update_camaras($id, $idplantas, $nombre, $estado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_camaras SET id_plantas=:idplantas, nombre=:nombre, estado=:estado WHERE id=:id');
            $stmt->bindParam(':idplantas',$idplantas);
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':id',$id);

            if ($stmt->execute()) {
                return [
                    'status' => true,
                    'message' => 'Cámara actualizada correctamente'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Cámara '. $nombre .' no se ha podido actualizar correctamente'
                ];
            }

        }
    }

?>