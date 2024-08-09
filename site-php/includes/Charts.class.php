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
        $stmt = $conn->prepare('SELECT COUNT(DISTINCT internet.id) as cortes_internet,
                                        COUNT(DISTINCT energia.id) as cortes_energia,
                                        COUNT(DISTINCT robo.id) as robos
                                FROM cctv_plantas planta
                                LEFT JOIN cctv_reporte_corte_internet internet ON planta.id = internet.id_planta
                                LEFT JOIN cctv_reporte_corte_energia energia ON planta.id = energia.id_planta
                                LEFT JOIN cctv_reporte_robo robo ON planta.id = robo.id_planta
                                WHERE planta.id = :id_planta 
                                AND internet.fecha BETWEEN :fecha_inicio AND :fecha_fin
                                AND energia.fecha BETWEEN :fecha_inicio AND :fecha_fin
                                AND robo.fecha BETWEEN :fecha_inicio AND :fecha_fin');

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
