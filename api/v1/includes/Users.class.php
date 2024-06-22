<?php
    require_once('Database.class.php');

    class Users{
        public static function create_users($idperfil,$nombres,$apellidos,$email,$password,){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_users (id_perfil,nombres,apellidos,email,password,codigo_google_2fa,fecha_creacion,estado)
                VALUES(:idperfil,:nombres,:apellidos,:email,:password,:codigogoogle2fa,:fechacreacion, 0)');
            $stmt->bindParam(':idperfil',$idperfil);
            $stmt->bindParam(':nombres',$nombres);
            $stmt->bindParam(':apellidos',$apellidos);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':password',$password);
            $stmt->bindParam(':codigogoogle2fa',$codigogoogle2fa);
            $stmt->bindParam(':fechacreacion',$fechacreacion);
            if($stmt->execute()){
                header('HTTP/1.1 201 Users creado correctamente');
            } else {
                header('HTTP/1.1 404 Users no se ha creado correctamente');
            }
        }

        public static function delete_users_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM cctv_users WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                header('HTTP/1.1 201 Users borrado correctamente');
            } else {
                header('HTTP/1.1 404 Users no se ha podido borrar correctamente');
            }
        }

        public static function get_all_users(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_users');
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                header('HTTP/1.1 201 OK');
            } else {
                header('HTTP/1.1 404 No se ha podido consultar los usuarios');
            }
        }

        public static function get_users_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_users WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll();
                echo json_encode($result);
                header('HTTP/1.1 201 OK');
            } else {
                header('HTTP/1.1 404 No se ha podido consultar los users');
            }
        }

        public static function update_users($id, $idperfil, $nombres, $apellidos, $email, $password, $codigogoogle2fa, $estado){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('UPDATE cctv_users SET id_perfil=:idperfil, nombres=:nombres, apellidos=:apellidos,email=:email, password=:password, codigo_google_2fa=:codigogoogle2fa, estado=:estado WHERE id=:id');
            $stmt->bindParam(':idperfil',$idperfil);
            $stmt->bindParam(':nombres',$nombres);
            $stmt->bindParam(':apellidos',$apellidos);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':password',$password);
            $stmt->bindParam(':codigogoogle2fa',$codigogoogle2fa);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':id',$id);

            if($stmt->execute()){
                header('HTTP/1.1 201 Perfil actualizado correctamente');
            } else {
                header('HTTP/1.1 404 Perfil no se ha podido actualizar correctamente');
            }

        }
    }

?>