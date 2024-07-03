<?php
    require_once('Database.class.php');

    class Token{
        public static function fecha_creacion(){
            $fechacreacion = date("Y-m-d H:i:s");
            return $fechacreacion;
        }
        
        public static function str_rand(int $length = 64){ // 64 = 32
            $length = ($length < 4) ? 4 : $length;
            return bin2hex(random_bytes(($length-($length%2))/2));
        }

        public static function getAuthorizationHeader(){
            $headers = null;
            if (isset($_SERVER['Authorization'])) {
                $headers = trim($_SERVER["Authorization"]);
            }
            else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
                $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
            } elseif (function_exists('apache_request_headers')) {
                $requestHeaders = apache_request_headers();
                // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
                $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
                //print_r($requestHeaders);
                if (isset($requestHeaders['Authorization'])) {
                    $headers = trim($requestHeaders['Authorization']);
                }
            }
            return $headers;
        }
        
        /**
         * get access token from header
         * */
        public static function getBearerToken() {
            $headers = Token::getAuthorizationHeader();
            // HEADER: Get the access token from the header
            if (!empty($headers)) {
                if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                    return $matches[1];
                }
            }
            return null;
        }

        public static function checkTokenByBearer($token){
            $database = new Database();
            $conn = $database->getConnection();
            $fecha = Token::fecha_creacion();
            $stmt = $conn->prepare('SELECT * FROM cctv_tokens WHERE token=:token and fecha>:fecha and estado=0');
            $stmt->bindParam(':token',$token);
            $stmt->bindParam(':fecha',$fecha);
            if($stmt->execute()){
                $rows = $stmt->rowCount();
                if($rows>0){
                    return true;
                }else{
                    return false;
                }
            } else {
                return false;
            }
        }
       
    }
?>