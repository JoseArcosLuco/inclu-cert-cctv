<?php
require_once('Database.class.php');

class ChartData
{

    public static function obtenerChartData()
    {
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
            return $stmt->fetchAll();
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

    public static function obtenerDatosClientes($id)
    {
        $database = new Database();
        $conn = $database->getConnection();
        $sql = "
            SELECT 
                p.id as id, 
                p.nombre as nombre,
                COALESCE(r.robo, 0) + COALESCE(i.internet, 0) + COALESCE(e.energia, 0) as reportes,
                COALESCE(grc.reporte_camaras, 0) + COALESCE(rd.reporte_diario, 0) as contadorReporte
            FROM 
            cctv_plantas p
            LEFT JOIN (
                SELECT id_planta, COUNT(*) as robo
                FROM cctv_reporte_robo
                GROUP BY id_planta
            ) r ON p.id = r.id_planta
            LEFT JOIN (
                SELECT id_planta, COUNT(*) as internet
                FROM cctv_reporte_corte_internet
                GROUP BY id_planta
            ) i ON p.id = i.id_planta
            LEFT JOIN (
                SELECT id_planta, COUNT(*) as energia
                FROM cctv_reporte_corte_energia
                GROUP BY id_planta
            ) e ON p.id = e.id_planta
            LEFT JOIN (
                SELECT r.id_planta, COUNT(*) as reporte_camaras
                FROM cctv_gestion_reporte_completo_camaras rc
                JOIN cctv_gestion_reporte_completo r ON rc.id_gestion = r.id
                GROUP BY r.id_planta
            ) grc ON p.id = grc.id_planta
            LEFT JOIN (
                SELECT id_planta, COUNT(*) as reporte_diario
                FROM cctv_reporte_diario
                GROUP BY id_planta
            ) rd ON p.id = rd.id_planta
            WHERE 
            p.id_clientes = :id
            ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
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
            GROUP_CONCAT(DISTINCT internet.fecha ORDER BY internet.fecha ASC) as fechas_internet,
            COUNT(DISTINCT energia.id) as cortes_energia,
            GROUP_CONCAT(DISTINCT energia.fecha ORDER BY energia.fecha ASC) as fechas_energia,
            COUNT(DISTINCT robo.id) as robos,
            GROUP_CONCAT(DISTINCT robo.fecha ORDER BY robo.fecha ASC) as fechas_robos
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
