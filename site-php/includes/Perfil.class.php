<?php
    require_once('Database.class.php');

    class Perfil{
        public static function create_perfil($name){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_perfil (nombre,estado)
                VALUES(:name, 0)');
            $stmt->bindParam(':name',$name);
            if($stmt->execute()){
                header('HTTP/1.1 201 Perfil creado correctamente');
            } else {
                header('HTTP/1.1 404 Perfil no se ha creado correctamente');
            }
        }

        public static function delete_perfil_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM cctv_perfil WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                header('HTTP/1.1 201 Perfil borrado correctamente');
            } else {
                header('HTTP/1.1 404 Perfil no se ha podido borrar correctamente');
            }
        }

        public static function get_all_perfiles(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_perfil');
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                header('HTTP/1.1 201 OK');
            } else {
                header('HTTP/1.1 404 No se ha podido consultar los perfiles');
            }
        }

        public static function get_perfil_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_perfil WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                header('HTTP/1.1 201 OK');
            } else {
                header('HTTP/1.1 404 No se ha podido consultar los perfiles');
            }
        }

        public static function update_perfil($id, $name, $estado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_perfil SET nombre=:name, estado=:estado WHERE id=:id');
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':id',$id);

            if($stmt->execute()){
                header('HTTP/1.1 201 Perfil actualizado correctamente');
            } else {
                header('HTTP/1.1 404 Perfil no se ha podido actualizar correctamente');
            }

        }
    }

?>