<?php
    require_once('Database.class.php');

    class Ciudades{
        public static function create_ciudad($name){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_ciudad (nombre,estado)
                VALUES(:name, 0)');
            $stmt->bindParam(':name',$name);
            if($stmt->execute()){
                header('HTTP/1.1 201 Cliente creado correctamente');
            } else {
                header('HTTP/1.1 404 Cliente no se ha creado correctamente');
            }
        }

        public static function delete_ciudad_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM cctv_ciudad WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                header('HTTP/1.1 201 Cliente borrad correctamente');
            } else {
                header('HTTP/1.1 404 Cliente no se ha podido borrar correctamente');
            }
        }

        public static function get_all_ciudades(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_ciudad');
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                header('HTTP/1.1 201 OK');
            } else {
                header('HTTP/1.1 404 No se ha podido consultar los clientes');
            }
        }

        public static function get_ciudad_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_ciudad WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                header('HTTP/1.1 201 OK');
            } else {
                header('HTTP/1.1 404 No se ha podido consultar los clientes');
            }
        }

        public static function update_ciudad($id, $name, $estado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_ciudad SET nombre=:name, estado=:estado WHERE id=:id');
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':id',$id);

            if($stmt->execute()){
                header('HTTP/1.1 201 Cliente actualizado correctamente');
            } else {
                header('HTTP/1.1 404 Cliente no se ha podido actualizar correctamente');
            }

        }
    }

?>