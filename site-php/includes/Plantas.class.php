<?php
    require_once('Database.class.php');

    class Plantas{
        public static function create_plantas($idcomuna,$idcomisarias,$idtipoplanta,$idclientes,$nombre,$grupo,$ubicacion,$encargadocontacto,$encargadoemail,$encargadotelefono,$mapa,$estado, $marcaDispositivos, 
        $modelosDispositivos, $cantidadCamaras, $modeloCamaras, $codificacionCamaras, $analiticas, $sensores, $tamanoGrabacion, $diasGrabacion, $alarmaVoceo, $sirenas, $internet, $proveedorInternet, $p2p, $autoregistros){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_plantas (id_comuna,id_comisarias,id_tipo_planta,id_clientes,nombre,grupo,ubicacion,encargado_contacto,encargado_email,encargado_telefono,mapa,estado, marca_dispositivos, modelos_dispositivos, cantidad_camaras, tipo_modelo_camaras, codificacion_camaras, analiticas, sensores, tamano_grabacion, dias_grabacion, alarma_voceo, sirenas, internet, proveedor_internet, p2p, autoregistro)
                VALUES(:idcomuna,:idcomisarias,:idtipoplanta,:id_clientes,:nombre,:grupo,:ubicacion,:encargadocontacto,:encargadoemail,:encargadotelefono,:mapa,:estado, :marcaDispositivos, :modelosDispositivos, :cantidadCamaras, :modeloCamaras, :codificacionCamaras, :analiticas, :sensores, :tamanoGrabacion, :diasGrabacion, :alarmaVoceo, :sirenas, :internet, :proveedorInternet, :p2p, :autoregistros)');
            
            $stmt->bindParam(':idcomuna',$idcomuna);
            $stmt->bindParam(':idcomisarias',$idcomisarias);
            $stmt->bindParam(':idtipoplanta',$idtipoplanta);
            $stmt->bindParam(':id_clientes',$idclientes);
            $stmt->bindParam(':nombre',$nombre);
            $stmt->bindParam(':grupo',$grupo);
            $stmt->bindParam(':ubicacion',$ubicacion);
            $stmt->bindParam(':encargadocontacto',$encargadocontacto);
            $stmt->bindParam(':encargadoemail',$encargadoemail);
            $stmt->bindParam(':encargadotelefono',$encargadotelefono);
            $stmt->bindParam(':mapa',$mapa);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':marcaDispositivos',$marcaDispositivos);
            $stmt->bindParam(':modelosDispositivos',$modelosDispositivos);
            $stmt->bindParam(':cantidadCamaras',$cantidadCamaras);
            $stmt->bindParam(':modeloCamaras',$modeloCamaras);
            $stmt->bindParam(':codificacionCamaras',$codificacionCamaras);
            $stmt->bindParam(':analiticas',$analiticas);
            $stmt->bindParam(':sensores',$sensores);
            $stmt->bindParam(':tamanoGrabacion',$tamanoGrabacion);
            $stmt->bindParam(':diasGrabacion',$diasGrabacion);
            $stmt->bindParam(':alarmaVoceo',$alarmaVoceo);
            $stmt->bindParam(':sirenas',$sirenas);
            $stmt->bindParam(':internet',$internet);
            $stmt->bindParam(':proveedorInternet',$proveedorInternet);
            $stmt->bindParam(':p2p',$p2p);
            $stmt->bindParam(':autoregistros',$autoregistros);

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
                return [];
            }
        }

        public static function get_all_plantas_short_data(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT id, id_comuna, id_comisarias, id_tipo_planta, id_clientes, nombre, grupo, ubicacion, estado FROM cctv_plantas');
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                return $result;
            } else {
                return [];
            }
        }

        public static function get_plantas_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT p.* ,
                                    ciudad.id as id_ciudad,
                                    ciudad.nombre as nombre_ciudad
                                    FROM cctv_plantas p
                                    LEFT JOIN cctv_comunas comuna ON p.id_comuna = comuna.id
                                    LEFT JOIN cctv_ciudad ciudad ON comuna.id_ciudad = ciudad.id
                                    WHERE p.id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                return $result;
            } else {
                return [];
            }
        }

        public static function get_plantas_by_cliente_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT  COUNT(c.id) as camaras, p.*
                                    FROM cctv_plantas p 
                                    LEFT JOIN cctv_camaras c ON p.id = c.id_plantas
                                    WHERE id_clientes=:id
                                    GROUP BY p.id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } else {
                return [];
            }
        }

        public static function update_plantas($id, $idcomuna, $idcomisarias, $idtipoplanta,$idcliente,$nombre, $grupo, $ubicacion, $encargadocontacto, $encargadoemail, $encargadotelefono, $mapa, $estado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_plantas SET id_comuna=:idcomuna,id_comisarias=:idcomisarias,id_tipo_planta=:idtipoplanta,id_clientes=:idclientes,nombre=:nombre,grupo=:grupo,ubicacion=:ubicacion,encargado_contacto=:encargadocontacto,encargado_email=:encargadoemail,encargado_telefono=:encargadotelefono,mapa=:mapa,estado=:estado WHERE id=:id');
            $stmt->bindParam(':idcomuna',$idcomuna);
            $stmt->bindParam(':idcomisarias',$idcomisarias);
            $stmt->bindParam(':idtipoplanta',$idtipoplanta);
            $stmt->bindParam(':idclientes',$idcliente);
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