<?php
    require_once('Database.class.php');

    class Informes{
        
        public static function get_client_by_plant_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $sql = "select gp.id,c.nombre as nombrecliente,p.nombre as planta,concat(u.nombres,' ',u.apellidos) as nombreusuario,t.nombre as turno,gp.horario,";
            $sql .= "(case when gp.planta_en_linea=1 Then 'Si' else 'No' end) as planta_en_linea, ";
            $sql .= "gp.con_intermitencia as camarasintermitencia,gp.camaras_sin_conexion,gp.camaras_totales,gp.observaciones, gp.fecha_gestion,gp.fecha_registro, ";
            $sql .= "(case when gp.estado=1 Then 'Aprobado' else 'Por Aprobar' end) as estadoreporte ";
            $sql .= "from cctv_gestion_plantas as gp ";
            $sql .= "inner join cctv_plantas as p on (p.id = gp.id_plantas) ";
            $sql .= "inner join cctv_clientes as c on (c.id = p.id_clientes) ";
            $sql .= "inner join cctv_users as u on (u.id = gp.id_users) ";
            $sql .= "inner join cctv_turnos as t on (t.id = gp.id_turno) WHERE gp.id = :id";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        public static function get_informe_camaras($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT c.nombre as nombrecamara,(case when gpc.estado=1 Then "Habilitado" else "No Activa" end) as estadocamara,gpc.observacion  FROM cctv_camaras as c inner join cctv_gestion_plantas_camaras as gpc on (gpc.id_camaras = c.id) WHERE gpc.id_gestion_plantas = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public static function get_periodicos_by_date($fecha){
            $database = new Database();
            $conn = $database->getConnection();
            $sql = "
                SELECT 
                rd.id, 
                rd.fecha,
                rd.camaras,
                rd.camaras_online,
                rd.canal,
                rd.observacion,
                CONCAT(u.nombres, ' ', u.apellidos) as operador,
                c.nombre as cliente,
                p.nombre as planta
                FROM cctv_reporte_diario rd
                INNER JOIN cctv_clientes c ON rd.id_cliente = c.id AND c.estado = 1
                INNER JOIN cctv_plantas p ON rd.id_planta = p.id AND c.estado = 1
                INNER JOIN cctv_operadores o ON rd.id_operador = o.id
                INNER JOIN cctv_users u ON o.id_users = u.id
                WHERE DATE_FORMAT(rd.fecha, '%Y-%m-%d %H:%i') = DATE_FORMAT(:fecha, '%Y-%m-%d %H:%i');
            ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }

?>