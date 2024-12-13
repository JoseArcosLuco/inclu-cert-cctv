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

        public static function get_all_reportes($id_cliente, $fecha, $planta) {
            $database = new Database();
            $conn = $database->getConnection();
        
            $sql = 'SELECT 
                        r.*, 
                        COUNT(DISTINCT rr.id) AS cantidad_robos,  
                        COUNT(DISTINCT ce.id) AS cantidad_corte_energia,  
                        COUNT(DISTINCT ci.id) AS cantidad_corte_internet,
                        (
                        SELECT COUNT(energia.id) + COUNT(internet.id)
                        FROM cctv_plantas planta 
                        LEFT JOIN cctv_reporte_corte_energia energia ON energia.id_planta = planta.id AND energia.estado = 1
                        LEFT JOIN cctv_reporte_corte_internet internet ON internet.id_planta = planta.id AND internet.estado = 1
                        WHERE planta.id = r.id_planta
                        ) AS reconectores_abiertos
                    FROM 
                        cctv_reporte_diario r
                    INNER JOIN 
                        cctv_plantas p ON p.id = r.id_planta
                    LEFT JOIN 
                        cctv_reporte_robo rr ON rr.id_planta = p.id AND DATE(rr.fecha) = DATE(r.fecha)
                    LEFT JOIN 
                        cctv_reporte_corte_energia ce ON ce.id_planta = p.id AND DATE(ce.fecha) = DATE(r.fecha)
                    LEFT JOIN 
                        cctv_reporte_corte_internet ci ON ci.id_planta = p.id AND DATE(ci.fecha) = DATE(r.fecha)';
        
            $conditions = [];
            $params = [];
        
            if (!empty($id_cliente)) {
                $conditions[] = 'r.id_cliente = :id_cliente';
                $params[':id_cliente'] = $id_cliente;
            }
        
            if (!empty($fecha)) {
                $conditions[] = 'r.fecha = :fecha';
                $params[':fecha'] = $fecha;
            }
        
            if (!empty($planta)) {
                $conditions[] = 'r.id_planta = :planta';
                $params[':planta'] = $planta;
            }
        
            if (count($conditions) > 0) {
                $sql .= ' WHERE ' . implode(' AND ', $conditions);
            }
        
            $sql .= ' GROUP BY r.id, r.fecha ORDER BY r.id DESC;';
            
            //echo('sql:.. '.$sql);

            $stmt = $conn->prepare($sql);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
        
            if($stmt->execute()) {
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