<?php
    require_once('Database.class.php');

    class Plantas{
        public static function create_plantas($idcomuna,$idcomisarias,$idtipoplanta,$nombre,$grupo,$ubicacion,$encargadocontacto,$encargadoemail,$encargadotelefono,$mapa,$estado){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_plantas (id_comuna,id_comisarias,id_tipo_planta,nombre,grupo,ubicacion,encargado_contacto,encargado_email,encargado_telefono,mapa,estado)
                VALUES(:idcomuna,:idcomisarias,:idtipoplanta,:nombre,:grupo,:ubicacion,:encargadocontacto,:encargadoemail,:encargadotelefono,:mapa,:estado)');
            
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

            if ($stmt->execute()) {
                return [
                    'status' => true,
                    'message' => 'Planta creada correctamente.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Error al crear la Planta.'
                ];
            }
        }

        public static function delete_plantas_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM cctv_plantas WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                return [
                    'status' => true,
                    'message' => 'Planta borrada correctamente.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'No se ha podido borrar la planta.'
                ];
            }
        }

        public static function get_all_plantas(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_plantas');
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                return $result;
            } else {
                header('HTTP/1.1 404 No se ha podido consultar las plantas');
                return [];
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

            $stmt = $conn->prepare('UPDATE cctv_plantas SET id_comuna=:idcomuna,id_comisarias=:idcomisarias,id_tipo_planta=:idtipoplanta,nombre=:nombre,grupo=:grupo,ubicacion=:ubicacion,encargado_contacto=:encargadocontacto,encargado_email=:encargadoemail,encargado_telefono=:encargadotelefono,mapa=:mapa,estado=:estado WHERE id=:id');
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

            if ($stmt->execute()) {
                return [
                    'status' => true,
                    'message' => 'Planta actualizada correctamente'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Planta no se ha podido actualizar correctamente'
                ];
            }

        }
    }

?>