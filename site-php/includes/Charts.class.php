<?php
require_once('Database.class.php');

class ChartData
{

    public static function obtenerChartData($fecha_inicio, $fecha_fin)
    {
        $database = new Database();
        $conn = $database->getConnection();
        $sql = "
        SELECT 
            cliente.nombre AS cliente,
            DATE(reportes.fecha) AS fecha,
            COUNT(*) AS total_reportes
        FROM (
            SELECT id_cliente, fecha FROM cctv_reporte_robo
            UNION ALL
            SELECT id_cliente, fecha FROM cctv_reporte_corte_energia
            UNION ALL
            SELECT id_cliente, fecha FROM cctv_reporte_corte_internet
        ) AS reportes
        JOIN cctv_clientes cliente ON cliente.id = reportes.id_cliente
        WHERE reportes.fecha BETWEEN :fecha_inicio AND :fecha_fin
        GROUP BY cliente.id, DATE(reportes.fecha)
        ORDER BY fecha;
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }

    public static function obtenerChartDataNormal() {
        $database = new Database();
        $conn = $database->getConnection();
        $sql = "
        SELECT cliente.nombre as nombre,
            COUNT(planta.id) as total_plantas
            FROM cctv_clientes cliente
            LEFT JOIN cctv_plantas planta ON cliente.id = planta.id_clientes
            GROUP BY cliente.id;
        ";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }

    public static function porcentajeReportes($id_cliente, $id_planta){
        $database = new Database();
        $conn = $database->getConnection();
        if (!empty($id_cliente)) {
            $sql = "SELECT ROUND(SUM(camaras_online) / SUM(camaras) * 100, 1) AS porcentaje
                    FROM cctv_reporte_diario rd
                    INNER JOIN cctv_plantas p ON p.id = rd.id_planta WHERE p.id_clientes = :id_cliente;";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(':id_cliente', $id_cliente);
                    
        } else if (!empty($id_planta)) {
            $sql = "SELECT ROUND(SUM(camaras_online) / SUM(camaras) * 100, 1) AS porcentaje
                    FROM cctv_reporte_diario
                    WHERE id_planta = :id_planta;";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(':id_planta', $id_planta);

        } else {
            $sql = "SELECT ROUND(SUM(camaras_online) / SUM(camaras) * 100, 1) AS porcentaje
                    FROM cctv_reporte_diario;
                    ";
                    $stmt = $conn->prepare($sql);
        }
        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        } else {
            return 0;
        }
    }

    public static function obtenerDatosClientes($id_cliente, $fecha_inicio, $fecha_fin)
        {
            $database = new Database();
            $conn = $database->getConnection();

            $sql = "
                SELECT 
                    p.id AS id, 
                    p.nombre AS nombre,
                    COALESCE(r.robo, 0) + COALESCE(i.internet, 0) + COALESCE(e.energia, 0) AS reportes,
                    COALESCE(grc.reporte_camaras, 0) + COALESCE(rd.reporte_diario, 0) AS contadorReporte,
                    MAX(DATE(r.fecha)) AS fecha_robo,
                    MAX(DATE(i.fecha)) AS fecha_internet,
                    MAX(DATE(e.fecha)) AS fecha_energia
                FROM 
                    cctv_plantas p
                LEFT JOIN (
                    SELECT id_planta, fecha, COUNT(*) AS robo
                    FROM cctv_reporte_robo
                    WHERE fecha BETWEEN :fecha_inicio AND :fecha_fin
                    GROUP BY id_planta, fecha
                ) r ON p.id = r.id_planta
                LEFT JOIN (
                    SELECT id_planta, fecha, COUNT(*) AS internet
                    FROM cctv_reporte_corte_internet
                    WHERE fecha BETWEEN :fecha_inicio AND :fecha_fin
                    GROUP BY id_planta, fecha
                ) i ON p.id = i.id_planta
                LEFT JOIN (
                    SELECT id_planta, fecha, COUNT(*) AS energia
                    FROM cctv_reporte_corte_energia
                    WHERE fecha BETWEEN :fecha_inicio AND :fecha_fin
                    GROUP BY id_planta, fecha
                ) e ON p.id = e.id_planta
                LEFT JOIN (
                    SELECT r.id_planta, r.fecha_registro, COUNT(*) AS reporte_camaras
                    FROM cctv_gestion_reporte_completo_camaras rc
                    JOIN cctv_gestion_reporte_completo r ON rc.id_gestion = r.id
                    WHERE r.fecha_registro BETWEEN :fecha_inicio AND :fecha_fin
                    GROUP BY r.id_planta, r.fecha_registro
                ) grc ON p.id = grc.id_planta
                LEFT JOIN (
                    SELECT id_planta, fecha, COUNT(*) AS reporte_diario
                    FROM cctv_reporte_diario
                    WHERE fecha BETWEEN :fecha_inicio AND :fecha_fin
                    GROUP BY id_planta, fecha
                ) rd ON p.id = rd.id_planta
                WHERE 
                    p.id_clientes = :id_cliente
                GROUP BY p.id, p.nombre
                ORDER BY fecha_robo,fecha_internet,fecha_energia;
            ";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_cliente', $id_cliente);
            $stmt->bindParam(':fecha_inicio', $fecha_inicio);
            $stmt->bindParam(':fecha_fin', $fecha_fin);

            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return [];
            }
        }


    public static function countReportesPlantas($id_planta, $fecha_inicio, $fecha_fin){
        $database = new Database();
        $conn = $database->getConnection();
        if (!empty($id_planta)){
            $sql = "SELECT 
                        COALESCE(grc.reporte_camaras, 0) + COALESCE(rd.reporte_diario, 0)
                    FROM 
                        cctv_plantas p
                    LEFT JOIN (
                        SELECT r.id_planta, COUNT(*) AS reporte_camaras
                        FROM cctv_gestion_reporte_completo_camaras rc
                        JOIN cctv_gestion_reporte_completo r ON rc.id_gestion = r.id
                        GROUP BY r.id_planta
                    ) grc ON p.id = grc.id_planta                
                    LEFT JOIN (
                        SELECT id_planta, COUNT(*) AS reporte_diario
                        FROM cctv_reporte_diario
                        GROUP BY id_planta
                    ) rd ON p.id = rd.id_planta
                    WHERE p.id = :id_planta;
                    ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id_planta', $id_planta);

        } else if (!empty($fecha_inicio) && !empty($fecha_fin)){
            $sql = "SELECT 
                    COALESCE(grc.reporte_camaras, 0) + COALESCE(rd.reporte_diario, 0)
                FROM 
                    cctv_plantas p
                LEFT JOIN (
                    SELECT r.id_planta, COUNT(*) AS reporte_camaras
                    FROM cctv_gestion_reporte_completo_camaras rc
                    JOIN cctv_gestion_reporte_completo r ON rc.id_gestion = r.id
                    WHERE r.fecha_registro BETWEEN :fecha_inicio AND :fecha_fin
                    GROUP BY r.id_planta
                ) grc ON p.id = grc.id_planta                
                LEFT JOIN (
                    SELECT id_planta, COUNT(*) AS reporte_diario
                    FROM cctv_reporte_diario
                    WHERE fecha BETWEEN :fecha_inicio AND :fecha_fin
                    GROUP BY id_planta
                ) rd ON p.id = rd.id_planta;
                ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':fecha_inicio', $fecha_inicio);
            $stmt->bindParam(':fecha_fin', $fecha_fin);

        }  else if (!empty($fecha_inicio) && empty($fecha_fin)){
            $sql = "SELECT 
                    COALESCE(grc.reporte_camaras, 0) + COALESCE(rd.reporte_diario, 0)
                FROM 
                    cctv_plantas p
                LEFT JOIN (
                    SELECT r.id_planta, COUNT(*) AS reporte_camaras
                    FROM cctv_gestion_reporte_completo_camaras rc
                    JOIN cctv_gestion_reporte_completo r ON rc.id_gestion = r.id
                    WHERE r.fecha_registro = :fecha_inicio
                    GROUP BY r.id_planta
                ) grc ON p.id = grc.id_planta                
                LEFT JOIN (
                    SELECT id_planta, COUNT(*) AS reporte_diario
                    FROM cctv_reporte_diario
                    WHERE fecha = :fecha_inicio
                    GROUP BY id_planta
                ) rd ON p.id = rd.id_planta;
                ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':fecha_inicio', $fecha_inicio);

        } else {
            $sql = "SELECT
                    COALESCE(grc.reporte_camaras, 0) + COALESCE(rd.reporte_diario, 0)
                FROM 
                    cctv_plantas p
                LEFT JOIN (
                    SELECT r.id_planta, COUNT(*) AS reporte_camaras
                    FROM cctv_gestion_reporte_completo_camaras rc
                    JOIN cctv_gestion_reporte_completo r ON rc.id_gestion = r.id
                ) grc ON p.id = grc.id_planta
                LEFT JOIN (
                    SELECT id_planta, COUNT(*) AS reporte_diario
                    FROM cctv_reporte_diario
                ) rd ON p.id = rd.id_planta;
                ";

            $stmt = $conn->prepare($sql);
        }
        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        } else {
            return [];
        }
    }

    public static function obtenerDatosWithoutFecha($id_planta)
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('SELECT COUNT(DISTINCT internet.id) as cortes_internet,
                                        COUNT(DISTINCT energia.id) as cortes_energia,
                                        COUNT(DISTINCT robo.id) as robos
                                FROM cctv_plantas planta
                                LEFT JOIN cctv_reporte_corte_internet internet ON planta.id = internet.id_planta
                                LEFT JOIN cctv_reporte_corte_energia energia ON planta.id = energia.id_planta
                                LEFT JOIN cctv_reporte_robo robo ON planta.id = robo.id_planta
                                WHERE planta.id = :id_planta AND (planta.estado = 1 OR planta.estado = 0)');

        $stmt->bindParam(':id_planta', $id_planta);

        if ($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            return [];
        }
    }

    public static function obtenerDatosWithFecha($id_planta, $fecha_inicio, $fecha_fin)
    {
        $database = new Database();
        $conn = $database->getConnection();
        $sql = "
        SELECT 
            COUNT(DISTINCT internet.id) as cortes_internet,
            GROUP_CONCAT(DISTINCT DATE(internet.fecha) ORDER BY internet.fecha ASC) as fechas_internet,
            COUNT(DISTINCT energia.id) as cortes_energia,
            GROUP_CONCAT(DISTINCT DATE(energia.fecha) ORDER BY energia.fecha ASC) as fechas_energia,
            COUNT(DISTINCT robo.id) as robos,
            GROUP_CONCAT(DISTINCT DATE(robo.fecha) ORDER BY robo.fecha ASC) as fechas_robos
        FROM 
            cctv_plantas planta
        LEFT JOIN 
            cctv_reporte_corte_internet internet 
            ON planta.id = internet.id_planta 
            AND (internet.fecha >= :fecha_inicio AND internet.fecha <= :fecha_fin)
        LEFT JOIN 
            cctv_reporte_corte_energia energia 
            ON planta.id = energia.id_planta 
            AND (energia.fecha >= :fecha_inicio AND energia.fecha <= :fecha_fin)
        LEFT JOIN 
            cctv_reporte_robo robo 
            ON planta.id = robo.id_planta 
            AND (robo.fecha >= :fecha_inicio AND robo.fecha <= :fecha_fin)
        WHERE 
            planta.id = :id_planta AND (planta.estado = 1 OR planta.estado = 0);
        ";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id_planta', $id_planta);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);

        if ($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            return [];
        }
    }
}
