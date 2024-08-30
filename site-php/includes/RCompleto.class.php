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
        $stmt = $conn->prepare('SELECT * FROM cctv_plantas WHERE id_clientes = :id_cliente');
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
                LEFT JOIN cctv_turnos t ON p.id_clientes = t.id
                LEFT JOIN cctv_operadores op ON t.id = op.id_turnos
                WHERE cam.id_plantas = :id_plantas AND op.estado = 1
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
}
