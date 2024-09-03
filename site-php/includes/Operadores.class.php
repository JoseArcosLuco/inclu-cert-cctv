<?php
require_once('Database.class.php');

class Operadores
{
    public static function create_operadores($idusers, $idturnos)
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('INSERT INTO cctv_operadores (id_turnos, id_users, estado)
                VALUES(:idturnos,:idusers, 1)');
        $stmt->bindParam(':idturnos', $idturnos);
        $stmt->bindParam(':idusers', $idusers);
        if ($stmt->execute()) {
            return [
                'status' => true,
                'message' => 'Usuario agregado correctamente.'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'No se ha podido añadir el usuario ' . $idusers
            ];
        }
    }

    public static function delete_operadores_by_id($id)
    {
        $database = new Database();
        $conn = $database->getConnection();

        $stmt = $conn->prepare('UPDATE cctv_operadores SET estado=0 WHERE id=:id');
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return [
                'status' => true,
                'message' => 'Operador eliminado correctamente.'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'No se ha podido añadir el operador ' . $id
            ];
        }
    }

    public static function get_all_operadores($idturnos)
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('SELECT * FROM cctv_operadores WHERE id_turnos=:idturnos AND estado=1');
        $stmt->bindParam(':idturnos', $idturnos);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            return $result;
        } else {
            return [];
        }
    }

    public static function get_all_unasigned_users()
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('SELECT *
                                    FROM cctv_users u
                                    WHERE NOT EXISTS (
                                        SELECT 1
                                        FROM cctv_operadores o
                                        WHERE o.id_users = u.id AND o.estado = 1
                                    );');
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            return $result;
        } else {
            return [];
        }
    }

    public static function get_all_operadores_without_turno()
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('SELECT CONCAT(u.nombres, " ", u.apellidos) AS nombre,
                                    u.id as id
                                    FROM cctv_operadores o
                                    JOIN cctv_users u ON o.id_users = u.id
                                    WHERE o.estado = 1;');
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            return $result;
        } else {
            return [];
        }
    }

    public static function get_operadores_by_id($id)
    {
        $database = new Database();
        $conn = $database->getConnection();
        $stmt = $conn->prepare('SELECT * FROM cctv_operadores WHERE id=:id');
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            $result = $stmt->fetchAll();
            echo json_encode($result);
            header('HTTP/1.1 201 OK');
        } else {
            header('HTTP/1.1 404 No se ha podido consultar los operadores');
        }
    }

    public static function update_operadores($id, $idturnos, $idusers, $estado)
    {
        $database = new Database();
        $conn = $database->getConnection();

        $stmt = $conn->prepare('UPDATE cctv_operadores SET id_turnos=:idturnos, id_users=:idusers, estado=:estado WHERE id=:id');
        $stmt->bindParam(':idturnos', $idturnos);
        $stmt->bindParam(':idusers', $idusers);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            header('HTTP/1.1 201 Operadores actualizado correctamente');
        } else {
            header('HTTP/1.1 404 Operadores no se ha podido actualizar correctamente');
        }
    }
}
