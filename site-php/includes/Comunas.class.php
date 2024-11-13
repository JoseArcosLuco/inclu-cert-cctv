<?php
    require_once('Database.class.php');

    class Comunas{
        public static function create_comuna($idciudad,$name){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_comunas (id_ciudad,nombre,estado)
                VALUES(:name, 0)');
            $stmt->bindParam(':idciudad',$idciudad);
            $stmt->bindParam(':name',$name);
            if($stmt->execute()){
                header('HTTP/1.1 201 Comuna creado correctamente');
            } else {
                header('HTTP/1.1 404 Comuna no se ha creado correctamente');
            }
        }

        public static function delete_comunas_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM cctv_comunas WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                header('HTTP/1.1 201 Comuna borrado correctamente');
            } else {
                header('HTTP/1.1 404 Comuna no se ha podido borrar correctamente');
            }
        }

        public static function get_all_comunas($idciudad){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_comunas 
                                    WHERE id_ciudad=:idciudad
                                    ORDER BY nombre
                                    ');
            $stmt->bindParam(':idciudad',$idciudad);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                return $result;
            } else {
                return [];
            }
        }

        public static function get_all_comunas_without_id(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_comunas');
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                return $result;
            } else {
                return [];
            }
        }

        public static function get_comunas_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_comunas WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                header('HTTP/1.1 201 OK');
            } else {
                header('HTTP/1.1 404 No se ha podido consultar los comunas');
            }
        }

        public static function update_comuna($id, $idciudad, $name, $estado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_comunas SET id_ciudad=:idciudad nombre=:name, estado=:estado WHERE id=:id');
            $stmt->bindParam(':idciudad',$idciudad);
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':id',$id);

            if($stmt->execute()){
                header('HTTP/1.1 201 Comuna actualizado correctamente');
            } else {
                header('HTTP/1.1 404 Comuna no se ha podido actualizar correctamente');
            }

        }
    }

?>