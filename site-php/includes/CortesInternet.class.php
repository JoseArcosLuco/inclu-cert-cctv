<?php
    require_once('Database.class.php');

    class CortesInternet{
        public static function create_corteInternet($id_planta, $id_cliente, $fecha,$fecha_fin, $observacion,$estado ,$id_usuario){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_reporte_corte_internet (id_planta,id_cliente,fecha,fecha_fin,observacion,estado,id_usuario)
                                    VALUES(:id_planta ,:id_cliente, :fecha,:fecha_fin , :observacion, :estado, :id_usuario)');

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

        public static function delete_corteInternet_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM cctv_reporte_corte_internet WHERE id=:id');
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
            $stmt = $conn->prepare('SELECT * FROM cctv_plantas WHERE id_clientes=:id AND (estado = 1 OR estado = 0)');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                return $result;
            } else {
                return [];
            }
        }

        public static function get_all_corteInternet(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_reporte_corte_internet');
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                return $result;
            } else {
                return [];
            }
        }

        public static function get_all_corteInternet_Activos(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT p.nombre as nombreplanta,rci.fecha,rci.fecha_fin,rci.observacion,u.nombres as nombreusuario, u.apellidos as apellidousuario 
                                    FROM cctv_reporte_corte_internet as rci
                                    INNER JOIN cctv_plantas as p on p.id = rci.id_planta
                                    INNER JOIN cctv_users as u on u.id = rci.id_usuario 
                                    WHERE rci.estado=1 ORDER BY rci.fecha desc');
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                return $result;
            } else {
                return [];
            }
        }

        public static function update_corteInternet($id, $fecha,$fecha_fin, $observacion,$estado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_reporte_corte_internet SET fecha=:fecha,fecha_fin=:fecha_fin, observacion=:observacion, estado=:estado WHERE id=:id');
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