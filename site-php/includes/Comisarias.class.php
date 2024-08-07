<?php
    require_once('Database.class.php');

    class Comisarias{
        
        public static function comisaria_existente($nombre) {
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT COUNT(*) FROM cctv_comisarias WHERE nombre = :nombre');
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        }
        
        public static function create_comisarias($nombre,$direccion,$telefono,$movil,$estado){
            
            if (self::comisaria_existente($nombre)) {
                return [
                    'status' => false,
                    'message' => 'El nombre comsaria ya está registrado.'
                ];
            }
            
            
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_comisarias (nombre,direccion,telefono,movil,estado)
                VALUES(:nombre,:direccion,:telefono,:movil,:estado)');
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':direccion',$direccion);
            $stmt->bindParam(':telefono',$telefono);
            $stmt->bindParam(':movil',$movil);
            $stmt->bindParam(':estado',$estado);
            if($stmt->execute()){
                return [
                    'status' => true,
                    'message' => 'comisaria creada correctamente'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'error al crear comisarias correctamente'
                ];
            }
        }

        public static function delete_comisarias_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('SELECT * FROM cctv_plantas WHERE id_comisarias = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $plantasTipoPlanta = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($plantasTipoPlanta)) {

                $stmt = $conn->prepare('DELETE FROM cctv_comisarias WHERE id=:id');
                $stmt->bindParam(':id',$id);
                if($stmt->execute()){
                    return [
                        'status' => true,
                        'message' => 'comisaria eliminada correctamente'
                    ];
                } else {
                    return [
                        'status' => false,
                        'message' => 'error al eliminar comisaria correctamente'
                    ];
                }
            } else {
                return [
                    'status' => false,
                    'plantas' => $plantasTipoPlanta
                ];
            }
        }

        public static function get_all_comisarias(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_comisarias');
            if($stmt->execute()){
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } else {
                header('HTTP/1.1 404 No se ha podido consultar los comisarias');
                return [];
            }
        }

        public static function get_comisarias_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_comisarias WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } else {
                header('HTTP/1.1 404 No se ha podido consultar los comisaria por id');
                return [];
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
                return [
                    'status' => true,
                    'message' => 'Comisaria actualizado correctamente'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Comisaria no se ha podido actualizar correctamente'
                ];
            }

        }
    }

?>