<?php
    require_once('Database.class.php');

    class Reportes{
        public static function create_reporte($idCliente ,$idPlanta, $idOperador,$fecha ,$camaras, $camarasOnline, $canal, $observacion){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_reporte_diario (fecha,camaras,camaras_online, canal, observacion, id_cliente, id_planta, id_operador)
                VALUES(:fecha,:camaras,:camaras_online, :canal, :observacion, :id_cliente, :id_planta, :id_operador)');
            $stmt->bindParam(':id_operador',$idOperador);
            $stmt->bindParam(':fecha',$fecha);
            $stmt->bindParam(':camaras',$camaras);
            $stmt->bindParam(':camaras_online',$camarasOnline);
            $stmt->bindParam(':canal',$canal);
            $stmt->bindParam(':observacion',$observacion);
            $stmt->bindParam(':id_cliente',$idCliente);
            $stmt->bindParam(':id_planta',$idPlanta);
            if ($stmt->execute()) {
                return [
                    'status' => true,
                    'message' => 'Reporte creado correctamente.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Error al crear el Reporte.'
                ];
            }
        }

        public static function delete_reporte_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM cctv_reporte_diario WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                return [
                    'status' => true,
                    'message' => 'Reporte '.$id.' borrado correctamente.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'No se ha podido eliminar el Reporte '.$id
                ];
            }
        }

        public static function get_all_reportes(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_reporte_diario');
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                return $result;
            } else {
                return [];
            }
        }

        public static function update_reporte($id, $camarasOnline, $canal, $observacion, $fecha){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_reporte_diario SET camaras_online=:camarasOnline, canal=:canal, observacion=:observacion, fecha=:fecha WHERE id=:id');

            $stmt->bindParam(':fecha',$fecha);
            $stmt->bindParam(':camarasOnline',$camarasOnline);
            $stmt->bindParam(':canal',$canal);
            $stmt->bindParam(':observacion',$observacion);
            $stmt->bindParam(':id',$id);

            if ($stmt->execute()) {
                return [
                    'status' => true,
                    'message' => 'Reporte '.$id.' actualizada correctamente'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Reporte '. $id .' no se ha podido actualizar correctamente'
                ];
            }

        }
    }

?>