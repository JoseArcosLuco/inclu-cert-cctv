<?php
    require_once('Database.class.php');

    class Turnos{
        
        public static function create_turno($nombre,$id_plantas,$id_jornada,$estado){
            
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_turnos(nombre,id_plantas,id_jornada,estado)
                VALUES(:nombre,:id_plantas,:id_jornada,:estado)');
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':id_plantas',$id_plantas);
            $stmt->bindParam(':id_jornada',$id_jornada);
            $stmt->bindParam(':estado',$estado);

            if($stmt->execute()){
                return [
                    'status' => true,
                    'message' => 'Turno '.$nombre .' creado correctamente.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Error al crear el Turno '.$nombre.'.'
                ];
            }
        }

        public static function delete_turno($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_turnos SET estado = 3 WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                return [
                    'status' => true,
                    'message' => 'Turno '.$id.' borrado correctamente.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'No se ha podido eliminar el Turno '.$id.'.'
                ];
            }
        }

        public static function get_all_turnos(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_turnos WHERE estado = 1 OR estado = 0');
            if($stmt->execute()){
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } else {
                return [
                    'status' => false,
                    'message' => 'No se ha podido leer la tabla Turnos.'
                ];
            }
        }

        public static function update_turnos($id, $nombre,$id_plantas, $id_jornada, $estado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_turnos SET nombre=:nombre,id_plantas=:id_plantas, id_jornada=:id_jornada, estado=:estado WHERE id=:id');
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':id_plantas',$id_plantas);
            $stmt->bindParam(':id_jornada',$id_jornada);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':id',$id);

            if($stmt->execute()){
                return [
                    'status' => true,
                    'message' => 'Turno '.$nombre.' actualizado correctamente'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'El Turno '.$nombre.' no se ha podido actualizar correctamente'
                ];
            }

        }
    }

?>