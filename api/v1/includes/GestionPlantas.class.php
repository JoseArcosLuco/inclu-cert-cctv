<?php
    require_once('Database.class.php');

    class Gestion_Plantas{
        public static function create_gestion_plantas($idusers,$idplantas,$plantaenlinea,$conintermitencia,$camarassinconexion,$camarastotales,$porcentajecamaraoperativa,$observaciones){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_gestion_plantas (id_users,id_plantas,planta_en_linea
            con_intermitencia,camaras_sin_conexion,camaras_totales,porcentaje_camara_operativa,observaciones,fecha_gestion,estado)
                VALUES(:idusers,:idplantas,:plantaenlinea,:conintermitencia,:camarassinconexion,:camarastotales,:porcentajecamaraoperativa,:observaciones,:fecha_gestion, 0)');
            $stmt->bindParam(':idusers',$idusers);
            $stmt->bindParam(':idplantas',$idplantas);
            $stmt->bindParam(':plantaenlinea',$plantaenlinea);
            $stmt->bindParam(':conintermitencia',$conintermitencia);
            $stmt->bindParam(':camarassinconexion',$camarassinconexion);
            $stmt->bindParam(':camarastotales',$camarastotales);
            $stmt->bindParam(':porcentajecamaraoperativa',$porcentajecamaraoperativa);
            $stmt->bindParam(':observaciones',$observaciones);
            $stmt->bindParam(':fecha_gestion',$fecha);
            
            if($stmt->execute()){
                header('HTTP/1.1 201 gestion plantas camaras creado correctamente');
            } else {
                header('HTTP/1.1 404 gestion plantas camaras no se ha creado correctamente');
            }
        }

        public static function delete_gestion_plantas_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM cctv_gestion_plantas WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                header('HTTP/1.1 201 Gestion Plantas borrado correctamente');
            } else {
                header('HTTP/1.1 404 Gestion Plantas no se ha podido borrar correctamente');
            }
        }

        public static function get_all_gestion_plantas(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_gestion_plantas');
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                header('HTTP/1.1 201 OK');
            } else {
                header('HTTP/1.1 404 No se ha podido consultar los gestion plantas ');
            }
        }

        public static function get_gestion_plantas_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_gestion_plantas WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                header('HTTP/1.1 201 OK');
            } else {
                header('HTTP/1.1 404 No se ha podido consultar las gestion plantas');
            }
        }

        public static function update_gestion_plantas($id,$idusers,$idplantas,$plantaenlinea,$conintermitencia,$camarassinconexion,$camarastotales,$porcentajecamaraoperativa,$observaciones, $estado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_gestion_plantas 
            SET id_users=:idusers, 
                id_plantas=:idplantas, 
                planta_en_linea=:plantaenlinea, 
                con_intermitencia=:conintermitencia,
                camaras_sin_conexion=:camarassinconexion,
                camaras_totales=:camarastotales,
                porcentaje_camara_operativa=:porcentajecamaraoperativa,
                observaciones=:observaciones,
                fecha_gestion=:fecha,
                estado=:estado 
            WHERE id=:id');
            $stmt->bindParam(':idusers',$idusers);
            $stmt->bindParam(':idplantas',$idplantas);
            $stmt->bindParam(':plantaenlinea',$plantaenlinea);
            $stmt->bindParam(':conintermitencia',$conintermitencia);
            $stmt->bindParam(':camarassinconexion',$camarassinconexion);
            $stmt->bindParam(':camarastotales',$camarastotales);
            $stmt->bindParam(':porcentajecamaraoperativa',$porcentajecamaraoperativa);
            $stmt->bindParam(':observaciones',$observaciones);
            $stmt->bindParam(':fecha',$fecha);
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