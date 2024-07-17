<?php
    require_once('Database.class.php');

    class Users{
        public static function fecha_creacion(){
            $fechacreacion = date("Y-m-d H:i:s");
            return $fechacreacion;
        }
        public static function hashearPass($password){
            $hash = crypt($password,"inclusiveHash$71/_");
            return $hash;
        }  

        public static function email_existente($email) {
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT COUNT(*) FROM cctv_users WHERE email = :email');
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        }
        
        public static function create_users($idperfil,$nombres,$apellidos,$email,$password,$codigogoogle2fa,$estado){
            if (self::email_existente($email)) {
                return [
                    'status' => false,
                    'message' => 'El correo electrónico ya está registrado.'
                ];
            }

            $database = new Database();
            $fechacreacion = Users::fecha_creacion();
            $hash = Users::hashearPass($password);
            
            $conn = $database->getConnection();
            $stmt = $conn->prepare('INSERT INTO cctv_users (id_perfil,nombres,apellidos,email,password,codigo_google_2fa,fecha_creacion,estado)
                VALUES(:idperfil,:nombres,:apellidos,:email,:password,:codigogoogle2fa,:fechacreacion, :estado)');
            $stmt->bindParam(':idperfil',$idperfil);
            $stmt->bindParam(':nombres',$nombres);
            $stmt->bindParam(':apellidos',$apellidos);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':password',$hash);
            $stmt->bindParam(':codigogoogle2fa',$codigogoogle2fa);
            $stmt->bindParam(':fechacreacion',$fechacreacion);
            $stmt->bindParam(':estado',$estado);
            if ($stmt->execute()) {
                return [
                    'status' => true,
                    'message' => 'Usuario creado correctamente.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Error al crear el usuario.'
                ];
            }
        }

        public static function delete_users_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();

            $stmt = $conn->prepare('DELETE FROM cctv_users WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                return [
                    'status' => true,
                    'message' => 'Usuario borrado correctamente.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'No se ha podido borrar el usuario.'
                ];
            }
        }

        public static function get_all_users(){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_users');
            if($stmt->execute()){
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } else {
                header('HTTP/1.1 404 No se ha podido consultar los usuarios');
                return [];
            }
        }

        public static function get_users_by_id($id){
            $database = new Database();
            $conn = $database->getConnection();
            $stmt = $conn->prepare('SELECT * FROM cctv_users WHERE id=:id');
            $stmt->bindParam(':id',$id);
            if($stmt->execute()){
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } else {
                header('HTTP/1.1 404 No se ha podido consultar los usuarios');
                return [];
            }
        }

        public static function update_users($id, $idperfil, $nombres, $apellidos, $email, $password, $codigogoogle2fa, $estado){
            $database = new Database();
            $conn = $database->getConnection();
            $hash = Users::hashearPass($password);
            $stmt = $conn->prepare('UPDATE cctv_users SET id_perfil=:idperfil, nombres=:nombres, apellidos=:apellidos,email=:email, password=:password, codigo_google_2fa=:codigogoogle2fa, estado=:estado WHERE id=:id');
            $stmt->bindParam(':idperfil',$idperfil);
            $stmt->bindParam(':nombres',$nombres);
            $stmt->bindParam(':apellidos',$apellidos);
            $stmt->bindParam(':email',$email);
            $stmt->bindParam(':password',$hash);
            $stmt->bindParam(':codigogoogle2fa',$codigogoogle2fa);
            $stmt->bindParam(':estado',$estado);
            $stmt->bindParam(':id',$id);

            if ($stmt->execute()) {
                return [
                    'status' => true,
                    'message' => 'Perfil actualizado correctamente'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Perfil no se ha podido actualizar correctamente'
                ];
            }

        }
    }

?>