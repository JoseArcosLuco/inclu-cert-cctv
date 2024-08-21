<?php
    require_once('Database.class.php');

    class NVR{
        public static function create_nvr($idPlanta, $numDispositivo, $serial,$estado){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_nvr (id_planta, numero_dispositivo, serial, estado)
                                    VALUES(:id_planta, :num_dispositivo, :serial, :estado)');

            $stmt->bindParam(':id_planta', $idPlanta);
            $stmt->bindParam(':num_dispositivo', $numDispositivo);
            $stmt->bindParam(':serial', $serial);
            $stmt->bindParam(':estado', $estado);
            if ($stmt->execute()) {
                return [
                    'status' => true,
                    'message' => 'NVR creado correctamente.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Error al crear el NVR.'
                ];
            }
        }

        public static function delete_nvr_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM cctv_nvr WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                return [
                    'status' => true,
                    'message' => 'Reporte eliminado correctamente.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'No se ha podido eliminar el Reporte '.$id
                ];
            }
        }

        public static function get_all_nvr($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_nvr WHERE id_planta=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                return $result;
            } else {
                return [];
            }
        }

        public static function update_nvr($id, $numDispositivo, $serial, $estado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_nvr SET numero_dispositivo=:num_dispositivo, serial=:serial, estado=:estado WHERE id=:id');

            $stmt->bindParam(':num_dispositivo',$numDispositivo);
            $stmt->bindParam(':serial',$serial);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':id',$id);

            if ($stmt->execute()) {
                return [
                    'status' => true,
                    'message' => 'Reporte actualizado correctamente'
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