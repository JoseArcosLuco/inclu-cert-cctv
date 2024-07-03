<?php
    require_once('Database.class.php');

    class Gestion_Plantas_Camaras{
        public static function create_gestion_plantas_camaras($idgestionplantas,$idcamaras,$observacion){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_gestion_plantas_camaras (id_gestion_plantas,id_camaras,observacion,estado)
                VALUES(:idgestionplantas,:idcamaras,:observacion, 0)');
            $stmt->bindParam(':idgestionplantas',$idgestionplantas);
            $stmt->bindParam(':idcamaras',$idcamaras);
            $stmt->bindParam(':observacion',$observacion);
            if($stmt->execute()){
                header('HTTP/1.1 201 gestion plantas camaras creado correctamente');
            } else {
                header('HTTP/1.1 404 gestion plantas camaras no se ha creado correctamente');
            }
        }

        public static function delete_gestion_plantas_camaras_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM cctv_gestion_plantas_camaras WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                header('HTTP/1.1 201 Gestion Plantas Camaras borrado correctamente');
            } else {
                header('HTTP/1.1 404 Gestion Plantas Camaras no se ha podido borrar correctamente');
            }
        }

        public static function get_all_gestion_plantas_camaras($idgestionplantas){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_gestion_plantas_camaras WHERE id_gestion_plantas=:idgestionplantas');
            $stmt->bindParam(':idgestionplantas',$idgestionplantas);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                header('HTTP/1.1 201 OK');
            } else {
                header('HTTP/1.1 404 No se ha podido consultar los gestion plantas camaras');
            }
        }

        public static function get_camaras_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_gestion_plantas_camaras WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                header('HTTP/1.1 201 OK');
            } else {
                header('HTTP/1.1 404 No se ha podido consultar las gestion plantas camaras');
            }
        }

        public static function update_gestion_plantas_camaras($id, $idgestionplantas, $idcamaras, $observacion, $estado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_gestion_plantas_camaras SET id_gestion_plantas=:idgestionplantas, id_camaras=:idcamaras, observacion=:observacion, estado=:estado WHERE id=:id');
            $stmt->bindParam(':idgestionplantas',$idgestionplantas);
            $stmt->bindParam(':idcamaras',$idcamaras);
            $stmt->bindParam(':observacion',$observacion);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':id',$id);

            if($stmt->execute()){
                header('HTTP/1.1 201 Gestion Plantas Camaras actualizado correctamente');
            } else {
                header('HTTP/1.1 404 Gestion Plantas Camaras no se ha podido actualizar correctamente');
            }

        }
    }

?>