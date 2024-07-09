<?php
    require_once('Database.class.php');

    class TipoPlanta{
        public static function create_tipo_planta($name){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_tipo_planta (nombre,estado)
                VALUES(:name, 0)');
            $stmt->bindParam(':name',$name);
            if($stmt->execute()){
                //header('HTTP/1.1 201 Tipo Planta creado correctamente');
                return true;
            } else {
                //header('HTTP/1.1 404 Tipo Planta no se ha creado correctamente');
                return false;
            }
        }

        public static function delete_tipo_planta_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            if (TipoPlanta::get_tipo_planta_by_id_exist($id)){
                $stmt = $conn->prepare('DELETE FROM cctv_tipo_planta WHERE id=:id');
                $stmt->bindParam(':id',$id);
                if($stmt->execute()){
                    return true;
                    //header('HTTP/1.1 201 Tipo Planta borrado correctamente');
                } else {
                    return false;
                    //header('HTTP/1.1 404 Tipo Planta no se ha podido borrar correctamente');
                }
            }else{
                return false;
            }
            
        }

        public static function get_all_tipo_planta(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_tipo_planta');
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                header('HTTP/1.1 201 OK');
            } else {
                header('HTTP/1.1 404 No se ha podido consultar los tipo planta');
            }
        }

        public static function get_tipo_planta_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_tipo_planta WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                //header('HTTP/1.1 201 OK');
            } else {
                //header('HTTP/1.1 404 No se ha podido consultar los tipo planta');
            }
        }
        public static function get_tipo_planta_by_name($name){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_tipo_planta WHERE nombre=:name');
            $stmt->bindParam(':name',$name);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                if(count($result)>0){
                    return true;
                }else{  
                    return false;
                }
            } else {
                return false;
            }
        }
        public static function get_tipo_planta_by_id_exist($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_tipo_planta WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                if(count($result)>0){
                    return true;
                }else{  
                    return false;
                }
            } else {
                return false;
            }
        }

        public static function update_tipo_planta($id, $name, $estado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_tipo_planta SET nombre=:name, estado=:estado WHERE id=:id');
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':id',$id);

            if($stmt->execute()){
                header('HTTP/1.1 201 Tipo Planta actualizado correctamente');
            } else {
                header('HTTP/1.1 404 Tipo Planta no se ha podido actualizar correctamente');
            }

        }
    }

?>