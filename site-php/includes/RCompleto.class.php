<?php
require_once('Database.class.php');

class ReporteCompleto
{
    public static function create_reporte($id_reporte, $id_operador, $id_camara, $estado, $visual, $analiticas, $recorrido, $evento, $grabaciones, $observacion)
    {
        try {
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare(
                'INSERT INTO cctv_gestion_reporte_completo_camaras 
                (id_camaras, id_gestion, observacion, estado, id_operador, visual, analiticas, recorrido, evento, grabaciones) 
                VALUES (:id_camara, :id_gestion, :observacion, :estado, :id_operador, :visual, :analiticas, :recorrido, :evento, :grabaciones)'
            );

            $stmt->bindParam(':id_camara', $id_camara);
            $stmt->bindParam(':id_gestion', $id_reporte);
            $stmt->bindParam(':observacion', $observacion);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':id_operador', $id_operador);
            $stmt->bindParam(':visual', $visual);
            $stmt->bindParam(':analiticas', $analiticas);
            $stmt->bindParam(':recorrido', $recorrido);
            $stmt->bindParam(':evento', $evento);
            $stmt->bindParam(':grabaciones', $grabaciones);

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
        } catch (PDOException $e) {
            return [
                'status' => false,
                'message' => 'Error al ejecutar la consulta: ' . $e->getMessage()
            ];
        }
    }

    public static function get_plantas($id_cliente)
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('SELECT * FROM cctv_plantas WHERE id_clientes = :id_cliente AND (estado = 1 OR estado = 0)');
        $stmt->bindParam(':id_cliente', $id_cliente);
        if ($stmt->execute()) {
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $response;
        } else {
            return [];
        }
    }

    public static function create_reporteGral($id_planta, $fecha, $usuario_id)
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('INSERT INTO cctv_gestion_reporte_completo (id_usuario,id_planta, fecha_registro ) VALUES (:usuario_id, :id_planta, :fecha)');
        $stmt->bindParam(':id_planta', $id_planta);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':usuario_id', $usuario_id);
        if ($stmt->execute()) {
            return [
                'status' => true,
                'message' => 'Reporte creado correctamente.',
                'lastInsertId' => $conn->lastInsertId() // Opcional: Retorna el último ID insertado
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Error al crear el Reporte.'
            ];
        }
    }

    public static function get_plantas_camaras($id_plantas)
    {
        $database = new Database();
        $conn = $database->getConnection();
        $sql = '
                SELECT cam.*,
                GROUP_CONCAT(op.id_users) as operador
                FROM cctv_camaras cam
                LEFT JOIN cctv_plantas p ON cam.id_plantas = p.id
                LEFT JOIN cctv_turnos t ON p.id = t.id_plantas
                LEFT JOIN cctv_operadores op ON t.id = op.id_turnos AND op.estado = 1
                WHERE cam.id_plantas = :id_plantas AND (cam.estado = 1 OR cam.estado = 0)
                GROUP BY cam.id;';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_plantas', $id_plantas);

        if ($stmt->execute()) {
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $response;
        } else {
            return [];
        }
    }

    public static function get_reportes($id_planta, $id_cliente, $fecha)
    {
        $database = new Database();
        $conn = $database->getConnection();

        $query = 'SELECT rp.*, 
                        r.id_planta as id_planta, 
                        r.id_usuario as id_usuario, 
                        r.fecha_registro as fecha
                FROM cctv_gestion_reporte_completo_camaras rp
                INNER JOIN cctv_gestion_reporte_completo r ON r.id = rp.id_gestion';

        $conditions = [];
        $params = [];

        if (!empty($id_cliente)) {
            $conditions[] = 'r.id_planta IN (SELECT p.id FROM cctv_plantas p WHERE p.id_clientes = :id_cliente)';
            $params[':id_cliente'] = $id_cliente;
        }

        if (!empty($id_planta)) {
            $conditions[] = 'r.id_planta = :id_planta';
            $params[':id_planta'] = $id_planta;
        }

        if (!empty($fecha)) {
            $conditions[] = 'DATE(r.fecha_registro) = :fecha';
            $params[':fecha'] = $fecha;
        }

        if (count($conditions) > 0) {
            $query .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $stmt = $conn->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        try {
            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception('Error al ejecutar la consulta');
            }
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }

    public static function edit_reporte($id, $id_operador, $estado, $visual, $analiticas, $recorrido, $evento, $grabaciones, $observacion)
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('UPDATE cctv_gestion_reporte_completo_camaras 
                                SET estado = :estado,
                                observacion = :observacion,
                                id_operador = :id_operador,
                                visual = :visual,
                                recorrido = :recorrido,
                                analiticas = :analiticas,
                                evento = :evento,
                                grabaciones = :grabaciones
                                WHERE id = :id ');

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id_operador', $id_operador);
        $stmt->bindParam(':visual', $visual);
        $stmt->bindParam(':recorrido', $recorrido);
        $stmt->bindParam(':analiticas', $analiticas);
        $stmt->bindParam(':evento', $evento);
        $stmt->bindParam(':grabaciones', $grabaciones);
        $stmt->bindParam(':observacion', $observacion);
        if ($stmt->execute()) {
            return [
                'status' => true,
                'message' => 'Reporte actualizado correctamente.'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Error al actualizar el Reporte.'
            ];
        }
    }

    public static function delete_reporte($id)
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('DELETE FROM cctv_gestion_reporte_completo_camaras WHERE id = :id');
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return [
                'status' => true,
                'message' => 'Reporte ' . $id . ' borrado correctamente.'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'No se ha podido eliminar el Reporte ' . $id
            ];
        }
    }
}
