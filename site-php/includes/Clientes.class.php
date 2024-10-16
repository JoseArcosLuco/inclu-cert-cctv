<?php
    require_once('Database.class.php');

    class Clientes{
        
        public static function cliente_existente($nombre) {
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT COUNT(*) FROM cctv_clientes WHERE nombre = :nombre');
            $stmt->bindParam(':nombre', $nombre);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        }
        public static function create_cliente($nombre, $email, $fecha_contrato, $contacto, $estado){
            
            if (self::cliente_existente($nombre)) {
                return [
                    'status' => false,
                    'message' => 'El nombre cliente ya está registrado favor intente con otro nombre.'
                ];
            }
            
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_clientes(nombre, email, fecha_contrato, contacto, estado)
                                    VALUES(:nombre, :email, :fecha_contrato, :contacto, :estado)');
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':fecha_contrato',$fecha_contrato);
            $stmt->bindParam(':contacto',$contacto);
            $stmt->bindParam(':estado',$estado);
            if($stmt->execute()){
                return [
                    'status' => true,
                    'message' => 'Cliente creado correctamente.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Error al crear Cliente..'
                ];
            }
        }

        public static function delete_client_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_clientes SET estado = 3 WHERE id = :id');
            $stmt->bindParam(':id', $id);
            if($stmt->execute()){
                return [
                    'status' => true,
                    'message' => 'Cliente '.$id.' eliminado correctamente.',
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'No se ha podido eliminar el cliente.'
                ];
            };
        }

        public static function get_all_clients(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_clientes WHERE (estado = 1 OR estado = 0)');
            if($stmt->execute()){
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } else {
                return [
                    'status' => false,
                    'message' => 'No se ha podido leer la tabla clientes.'
                ];
            }
        }

        public static function get_cliente_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_clientes WHERE id = :id');
            $stmt->bindParam(':id', $id);
            if($stmt->execute()){
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result;
            } else {
                return [
                    'status' => false,
                    'message' => 'No se ha podido leer la tabla clientes.'
                ];
            }
        }

        public static function update_cliente($id, $nombre ,$email, $fecha_contrato, $contacto, $estado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_clientes SET email=:email, nombre=:nombre, email=:email, fecha_contrato=:fecha_contrato, contacto=:contacto, estado=:estado WHERE id=:id');
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':fecha_contrato',$fecha_contrato);
            $stmt->bindParam(':contacto',$contacto);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':id',$id);

            if($stmt->execute()){
                return [
                    'status' => true,
                    'message' => 'Cliente actualizado correctamente'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'cliente no se ha podido actualizar correctamente'
                ];
            }

        }
    }

?>