<?php
    require_once('Database.class.php');

    class TipoPlanta{
        
        
        public static function tipoplanta_existente($nombre) {
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT COUNT(*) FROM cctv_tipo_planta WHERE nombre = :nombre');
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        }
        public static function create_tipo_planta($nombre,$estado){
            
            if (self::tipoplanta_existente($nombre)) {
                return [
                    'status' => false,
                    'message' => 'El nombre tipo planta ya está registrado.'
                ];
            }
            
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_tipo_planta (nombre,estado) VALUES (:nombre, :estado)');
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':estado',$estado);
            if($stmt->execute()){
                return [
                    'status' => true,
                    'message' => 'Tipo Planta creado correctamente.'
                ];
            } else {
                return [
                    'status' => true,
                    'message' => 'Error al crear el tipo planta..'
                ];
            }
        }

        public static function delete_tipo_planta_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('SELECT * FROM cctv_plantas WHERE id_tipo_planta = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $plantasTipoPlanta = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($plantasTipoPlanta)) {
                $stmt = $conn->prepare('DELETE FROM cctv_tipo_planta WHERE id=:id');
                $stmt->bindParam(':id',$id);
                if($stmt->execute()){
                    return [
                        'status' => true,
                        'message' => 'Tipo Planta borrado correctamente.'
                    ];
                } else {
                    return [
                        'status' => false,
                        'message' => 'No se ha podido borrar el registro revisar.'
                    ];
                }
            }else{
                return [
                    'status' => false,
                    'plantas' => $plantasTipoPlanta
                ];
            }
            
        }

        public static function get_all_tipo_planta(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_tipo_planta');
            if($stmt->execute()){
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } else {
                return [
                    'status' => false,
                    'message' => 'No se ha podido leer la tabla tipo planta.'
                ];
            }
        }

        public static function get_tipo_planta_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_tipo_planta WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } else {
                return [
                    'status' => false,
                    'message' => 'No se ha podido leer los datos solicitados get_tipo_planta_by_id.'
                ];
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
                return [
                    'status' => true,
                    'message' => 'tipo planta actualizado correctamente'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'tipo planta no se ha podido actualizar correctamente'
                ];
            }

        }
    }

?>