<?php
    require_once('Database.class.php');

    class Plantas{
        public static function create_plantas($idcomuna,$idcomisarias,$idtipoplanta,$nombre,$grupo,$ubicacion,$encargadocontacto,$encargadoemail,$encargadotelefono,$mapa){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_plantas (id_comuna,id_comisarias,id_tipo_planta,nombre,grupo,ubicacion,encargado_contacto,encargado_email,encargado_telefono,mapa,estado)
                VALUES(:idcomuna,:idcomisarias,:idtipoplanta,:nombre,:grupo,:ubicacion,:encargadocontacto,:encargadoemail,:encargadotelefono,:mapa, 0)');
            
            $stmt->bindParam(':idcomuna',$idcomuna);
            $stmt->bindParam(':idcomisarias',$idcomisarias);
            $stmt->bindParam(':idtipoplanta',$idtipoplanta);
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':grupo',$grupo);
            $stmt->bindParam(':ubicacion',$ubicacion);
            $stmt->bindParam(':encargadocontacto',$encargadocontacto);
            $stmt->bindParam(':encargadoemail',$encargadoemail);
            $stmt->bindParam(':encargadotelefono',$encargadotelefono);
            $stmt->bindParam(':mapa',$mapa);

            if($stmt->execute()){
                header('HTTP/1.1 201 Plantas creado correctamente');
            } else {
                header('HTTP/1.1 404 Plantas no se ha creado correctamente');
            }
        }

        public static function delete_plantas_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM cctv_plantas WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                header('HTTP/1.1 201 Plantas borrado correctamente');
            } else {
                header('HTTP/1.1 404 Plantas no se ha podido borrar correctamente');
            }
        }

        public static function get_all_plantas(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_plantas');
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                header('HTTP/1.1 201 OK');
            } else {
                header('HTTP/1.1 404 No se ha podido consultar las plantas');
            }
        }

        public static function get_plantas_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_plantas WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                header('HTTP/1.1 201 OK');
            } else {
                header('HTTP/1.1 404 No se ha podido consultar las plantas');
            }
        }

        public static function update_plantas($id, $idcomuna, $idcomisarias, $idtipoplanta, $nombre, $grupo, $ubicacion, $encargadocontacto, $encargadoemail, $encargadotelefono, $mapa, $estado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_plantas SET id_gestion_plantas=:idgestionplantas, id_camaras=:idcamaras, observacion=:observacion, estado=:estado WHERE id=:id');
            $stmt->bindParam(':idcomuna',$idcomuna);
            $stmt->bindParam(':idcomisarias',$idcomisarias);
            $stmt->bindParam(':idtipoplanta',$idtipoplanta);
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':grupo',$grupo);
            $stmt->bindParam(':ubicacion',$ubicacion);
            $stmt->bindParam(':encargadocontacto',$encargadocontacto);
            $stmt->bindParam(':encargadoemail',$encargadoemail);
            $stmt->bindParam(':encargadotelefono',$encargadotelefono);
            $stmt->bindParam(':mapa',$mapa);
            
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