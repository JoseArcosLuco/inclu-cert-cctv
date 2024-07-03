<?php
    require_once('Database.class.php');

    class Operadores{
        public static function create_operadores($idturnos,$idusers){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_operadores (id_turnos, id_users, estado)
                VALUES(:idturnos,:idusers, 0)');
            $stmt->bindParam(':idturnos',$idturnos);
            $stmt->bindParam(':idusers',$idusers);
            if($stmt->execute()){
                header('HTTP/1.1 201 Perfil creado correctamente');
            } else {
                header('HTTP/1.1 404 Perfil no se ha creado correctamente');
            }
        }

        public static function delete_operadores_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM cctv_operadores WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                header('HTTP/1.1 201 Operadores borrado correctamente');
            } else {
                header('HTTP/1.1 404 Operadores no se ha podido borrar correctamente');
            }
        }

        public static function get_all_operadores($idturnos){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_operadores WHERE id_turnos=:idturnos');
            $stmt->bindParam(':idturnos',$idturnos);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                header('HTTP/1.1 201 OK');
            } else {
                header('HTTP/1.1 404 No se ha podido consultar los operadores');
            }
        }

        public static function get_operadores_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_operadores WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                header('HTTP/1.1 201 OK');
            } else {
                header('HTTP/1.1 404 No se ha podido consultar los operadores');
            }
        }

        public static function update_operadores($id, $idturnos, $idusers, $estado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_operadores SET id_turnos=:idturnos, id_users=:idusers, estado=:estado WHERE id=:id');
            $stmt->bindParam(':idturnos',$idturnos);
            $stmt->bindParam(':idusers',$idusers);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':id',$id);

            if($stmt->execute()){
                header('HTTP/1.1 201 Operadores actualizado correctamente');
            } else {
                header('HTTP/1.1 404 Operadores no se ha podido actualizar correctamente');
            }

        }
    }

?>