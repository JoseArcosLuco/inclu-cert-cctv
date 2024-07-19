<?php
    require_once('Database.class.php');

    class Perfil{

        public static function nombre_existente($nombre) {
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT COUNT(*) FROM cctv_perfil WHERE nombre = :nombre');
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        }

        public static function create_perfil($nombre, $estado){

            if (self::nombre_existente($nombre)) {
                return [
                    'status' => false,
                    'message' => 'El Perfil '.$nombre.' ya está registrado.'
                ];
            }

            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_perfil (nombre,estado)
                VALUES(:nombre, :estado)');
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':estado',$estado);
            if ($stmt->execute()) {
                return [
                    'status' => true,
                    'message' => 'Perfil creado correctamente.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Error al crear el perfil.'
                ];
            }
        }

        public static function delete_perfil_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_users SET id_perfil = NULL WHERE id_perfil = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $stmt = $conn->prepare('DELETE FROM cctv_perfil WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                return [
                    'status' => true,
                    'message' => 'Perfil borrado correctamente.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'No se ha podido borrar el perfil '.$id
                ];
            }
        }

        public static function get_all_perfiles(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_perfil');
            if($stmt->execute()){
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } else {
                return [];
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

        public static function update_perfil($id, $nombre, $estado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_perfil SET nombre=:nombre, estado=:estado WHERE id=:id');
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':id',$id);

            if ($stmt->execute()) {
                return [
                    'status' => true,
                    'message' => 'Perfil actualizado correctamente'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Perfil no se ha podido actualizar correctamente'
                ];
            }

        }
    }

?>