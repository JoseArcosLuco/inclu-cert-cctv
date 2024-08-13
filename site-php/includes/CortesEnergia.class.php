<?php
    require_once('Database.class.php');

    class CortesEnergia{
        public static function create_corteEnergia($id_planta, $id_cliente, $fecha,$fecha_fin, $observacion,$estado, $id_usuario){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_reporte_corte_energia (id_planta,id_cliente,fecha,fecha_fin,observacion,estado, id_usuario)
                                    VALUES(:id_planta ,:id_cliente, :fecha ,:fecha_fin, :observacion, :estado, :id_usuario)');

            $stmt->bindParam(':id_usuario',$id_usuario);
            $stmt->bindParam(':id_planta',$id_planta);
            $stmt->bindParam(':id_cliente',$id_cliente);
            $stmt->bindParam(':fecha',$fecha);
            $stmt->bindParam(':fecha_fin',$fecha_fin);
            $stmt->bindParam(':observacion',$observacion);
            $stmt->bindParam(':estado',$estado);
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

        public static function delete_corteEnergia_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM cctv_reporte_corte_energia WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                return [
                    'status' => true,
                    'message' => 'Reporte eliminado correctamente.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'No se ha podido eliminar el Reporte '.$id
                ];
            }
        }

        public static function get_all_plantas($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_plantas WHERE id_clientes=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                return $result;
            } else {
                return [];
            }
        }

        public static function get_all_corteEnergia(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_reporte_corte_energia');
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                return $result;
            } else {
                return [];
            }
        }

        public static function update_corteEnergia($id, $fecha,$fecha_fin, $observacion,$estado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_reporte_corte_energia SET fecha=:fecha,fecha_fin=:fecha_fin, observacion=:observacion, estado=:estado WHERE id=:id');
            $stmt->bindParam(':fecha',$fecha);
            $stmt->bindParam(':fecha_fin',$fecha_fin);
            $stmt->bindParam(':observacion',$observacion);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':id',$id);

            if ($stmt->execute()) {
                return [
                    'status' => true,
                    'message' => 'Reporte actualizado correctamente'
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