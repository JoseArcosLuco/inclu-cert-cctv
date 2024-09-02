<?php
    require_once('Database.class.php');

    class Novedades{
        public static function create_novedades($id_planta, $id_cliente, $fecha,$fecha_fin, $observacion,$estado, $id_usuario ,$tipo_novedad){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_reporte_novedades (id_planta,id_cliente,fecha,fecha_fin,observacion,estado,id_usuario, tipo_novedad)
                                    VALUES(:id_planta ,:id_cliente, :fecha ,:fecha_fin, :observacion, :estado, :id_usuario, :tipo_novedad)');

            $stmt->bindParam(':id_usuario',$id_usuario);
            $stmt->bindParam(':id_planta',$id_planta);
            $stmt->bindParam(':id_cliente',$id_cliente);
            $stmt->bindParam(':fecha',$fecha);
            $stmt->bindParam(':fecha_fin',$fecha_fin);
            $stmt->bindParam(':observacion',$observacion);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':tipo_novedad',$tipo_novedad);
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

        public static function delete_novedades_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM cctv_reporte_novedades WHERE id=:id');
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

        public static function get_all_novedades($tipo_novedad){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_reporte_novedades as rn inner join cctv_users as u on (u.id = rn.id_usuario) WHERE tipo_novedad=:tipo_novedad ORDER BY rn.fecha desc');
            $stmt->bindParam(':tipo_novedad',$tipo_novedad);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                return $result;
            } else {
                return [];
            }
        }

        public static function get_all_novedades_top10($tipo_novedad){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT u.nombres as nombreusuario,u.apellidos as apellidousuario,p.nombre as nombreplanta,rn.observacion,rn.fecha 
                                    FROM cctv_reporte_novedades as rn 
                                    INNER JOIN cctv_users as u on (u.id = rn.id_usuario) 
                                    INNER JOIN cctv_plantas as p on (p.id = rn.id_planta) 
                                    WHERE tipo_novedad=:tipo_novedad ORDER BY rn.fecha desc limit 0,10');
            $stmt->bindParam(':tipo_novedad',$tipo_novedad);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                return $result;
            } else {
                return [];
            }
        }

        public static function update_novedades($id, $fecha,$fecha_fin, $observacion,$estado, $tipo_novedad){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_reporte_novedades SET fecha=:fecha,fecha_fin=:fecha_fin, observacion=:observacion, estado=:estado, tipo_novedad=:tipo_novedad WHERE id=:id');
            $stmt->bindParam(':fecha',$fecha);
            $stmt->bindParam(':fecha_fin',$fecha_fin);
            $stmt->bindParam(':observacion',$observacion);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':id',$id);
            $stmt->bindParam(':tipo_novedad',$tipo_novedad);

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