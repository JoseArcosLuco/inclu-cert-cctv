<?php
    require_once('Database.class.php');

    class Jornada{
        public static function jornada_existente($nombre) {
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT COUNT(*) FROM cctv_jornada WHERE nombre = :nombre');
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        }
        public static function create_jornada($nombre,$estado){
            
            if (self::jornada_existente($nombre)) {
                return [
                    'status' => false,
                    'message' => 'El nombre jornada ya está registrado favor intente con otro nombre.'
                ];
            }
            
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_jornada(nombre,estado)
                VALUES(:nombre, :estado)');
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':estado',$estado);

            if($stmt->execute()){
                return [
                    'status' => true,
                    'message' => 'Jornada creado correctamente.'
                ];
            } else {
                return [
                    'status' => true,
                    'message' => 'Error al crear la jornada..'
                ];
            }
        }

        public static function delete_jornada_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM cctv_jornada WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                return [
                    'status' => true,
                    'message' => 'Jornada borrado correctamente.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'No se ha podido borrar el registro revisar.'
                ];
            }
        }

        public static function get_all_jornadas(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_jornada');
            if($stmt->execute()){
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } else {
                return [
                    'status' => false,
                    'message' => 'No se ha podido leer la tabla jornada.'
                ];
            }
        }

        public static function get_jornada_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_jornada WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } else {
                return [
                    'status' => false,
                    'message' => 'No se ha podido leer los datos solicitados get_jornada_by_id.'
                ];
            }
        }

        public static function update_jornada($id, $name, $estado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_jornada SET nombre=:name, estado=:estado WHERE id=:id');
            $stmt->bindParam(':name',$name);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':id',$id);

            if($stmt->execute()){
                return [
                    'status' => true,
                    'message' => 'jornada actualizado correctamente'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'jornada no se ha podido actualizar correctamente'
                ];
            }

        }
    }

?>