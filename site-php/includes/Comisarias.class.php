<?php
    require_once('Database.class.php');

    class Comisarias{
        public static function create_comisarias($nombre,$direccion,$telefono,$movil){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_comisarias (nombre,direccion,telefono,movil,estado)
                VALUES(:name, 0)');
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':direccion',$direccion);
            $stmt->bindParam(':telefono',$telefono);
            $stmt->bindParam(':movil',$movil);
            if($stmt->execute()){
                header('HTTP/1.1 201 Comisarias creado correctamente');
            } else {
                header('HTTP/1.1 404 Comisarias no se ha creado correctamente');
            }
        }

        public static function delete_comisarias_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM cctv_comisarias WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                header('HTTP/1.1 201 Comisarias borrado correctamente');
            } else {
                header('HTTP/1.1 404 Comisarias no se ha podido borrar correctamente');
            }
        }

        public static function get_all_comisarias(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_comisarias');
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                header('HTTP/1.1 201 OK');
            } else {
                header('HTTP/1.1 404 No se ha podido consultar los comisarias');
            }
        }

        public static function get_comisarias_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_comisarias WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                header('HTTP/1.1 201 OK');
            } else {
                header('HTTP/1.1 404 No se ha podido consultar los comisarias');
            }
        }

        public static function update_comisarias($id, $nombre, $direccion, $telefono, $movil, $estado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_comisarias SET nombre=:nombre, direccion=:direccion, telefono=:telefono, movil=:movil, estado=:estado WHERE id=:id');
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':direccion',$direccion);
            $stmt->bindParam(':telefono',$telefono);
            $stmt->bindParam(':movil',$movil);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':id',$id);

            if($stmt->execute()){
                header('HTTP/1.1 201 Comisarias actualizado correctamente');
            } else {
                header('HTTP/1.1 404 Comisarias no se ha podido actualizar correctamente');
            }

        }
    }

?>