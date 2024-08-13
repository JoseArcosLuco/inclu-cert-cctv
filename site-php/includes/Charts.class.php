<?php
require_once('Database.class.php');

class ChartData
{

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
                                WHERE planta.id = :id_planta');

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
            planta.id = :id_planta;
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
