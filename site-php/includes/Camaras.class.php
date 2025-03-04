<?php
require_once('Database.class.php');

class Camaras
{
    public static function create_camaras($idplantas, $nombre, $modelo, $tipoCamara, $sn, $estado)
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('INSERT INTO cctv_camaras (id_plantas,nombre,estado, modelo, tipo_camara,sn)
                VALUES(:idplantas ,:nombre,:estado, :modelo, :tipoCamara, :sn)');
        
        $stmt->bindParam(':idplantas', $idplantas);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':tipoCamara', $tipoCamara);
        $stmt->bindParam(':sn', $sn);
        $stmt->bindParam(':estado', $estado);
        if ($stmt->execute()) {
            return [
                'status' => true,
                'message' => 'Cámara creada correctamente.'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Error al crear la cámara.'
            ];
        }
    }

    public static function delete_camaras_by_id($id)
    {
        $database = new Database();
        $conn = $database->getConnection();

        $stmt = $conn->prepare('UPDATE cctv_camaras SET estado = 3 WHERE id=:id');
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return [
                'status' => true,
                'message' => 'Cámara borrado correctamente.'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'No se ha podido borrar la Cámara ' . $id
            ];
        }
    }

    public static function get_plantas_by_cliente_id($id)
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('SELECT id, 
                                    id_clientes, 
                                    nombre 
                                FROM cctv_plantas
                                WHERE id_clientes=:id AND (estado = 1 OR estado = 0)');
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            return $result;
        } else {
            return [];
        }
    }

    public static function get_all_camaras($id_cliente, $id_planta)
    {
        $database = new Database();
        $conn = $database->getConnection();

        if (empty($id_cliente) && empty($id_planta)) {
            $stmt = $conn->prepare('SELECT c.*,
                                        clientes.id as id_clientes
                                    FROM cctv_camaras as c
                                    JOIN cctv_plantas p ON c.id_plantas = p.id AND (p.estado = 1 OR p.estado = 0)
                                    JOIN cctv_clientes clientes ON p.id_clientes = clientes.id AND (clientes.estado = 1 OR clientes.estado = 0)
                                    WHERE (c.estado = 1 OR c.estado = 0);');

        } else if (!empty($id_cliente) && empty($id_planta)) {
            $stmt = $conn->prepare('SELECT c.*,
                                        clientes.id as id_clientes
                                    FROM cctv_camaras AS c
                                    JOIN cctv_plantas p ON c.id_plantas = p.id
                                    JOIN cctv_clientes clientes ON p.id_clientes = clientes.id AND (clientes.estado = 1 OR clientes.estado = 0)
                                    WHERE clientes.id = :id_cliente
                                    AND (c.estado = 1 OR c.estado = 0);');
            $stmt->bindParam(':id_cliente', $id_cliente);

        } else if (!empty($id_cliente) && !empty($id_planta)) {
            $stmt = $conn->prepare('SELECT cam.*,
                                        clientes.id as id_clientes
                                    FROM cctv_camaras cam 
                                    JOIN cctv_plantas p ON cam.id_plantas = p.id
                                    JOIN cctv_clientes clientes ON p.id_clientes = clientes.id
                                    WHERE cam.id_plantas=:idplantas AND (cam.estado = 1 OR cam.estado = 0)
                                    AND (clientes.estado = 1 OR clientes.estado = 0)
                                    ;');
            $stmt->bindParam(':idplantas', $id_planta);
        }

        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            return $result;
        } else {
            return [];
        }
    }

    public static function get_all_camaras_with_cliente_id($id_cliente)
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('SELECT c.* 
                                    FROM cctv_camaras AS c
                                    JOIN cctv_plantas p ON c.id_plantas = p.id
                                    JOIN cctv_clientes clientes ON p.id_clientes = clientes.id
                                    WHERE clientes.id = :id_cliente
                                    AND (c.estado = 1 OR c.estado = 0);');
        $stmt->bindParam(':id_cliente', $id_cliente);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            return $result;
        } else {
            return [];
        }
    }

    public static function get_all_camaras_without_plantaId()
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('SELECT * FROM cctv_camaras WHERE estado = 1 OR estado = 0');
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            return $result;
        } else {
            return [];
        }
    }

    public static function get_camaras_by_id($id)
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('SELECT * FROM cctv_camaras WHERE id=:id');
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            echo json_encode($result);
            header('HTTP/1.1 201 OK');
        } else {
            header('HTTP/1.1 404 No se ha podido consultar las camaras');
        }
    }

    public static function update_camaras($id, $idplantas, $nombre, $estado)
    {
        $database = new Database();
        $conn = $database->getConnection();

        $stmt = $conn->prepare('UPDATE cctv_camaras SET id_plantas=:idplantas, nombre=:nombre, estado=:estado WHERE id=:id');
        $stmt->bindParam(':idplantas', $idplantas);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return [
                'status' => true,
                'message' => 'Cámara actualizada correctamente'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Cámara ' . $nombre . ' no se ha podido actualizar correctamente'
            ];
        }
    }
}
