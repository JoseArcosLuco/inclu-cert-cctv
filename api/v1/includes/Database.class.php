<?php
    class Database{
        private $host = 'localhost';
        private $user = 'ibdfohwj_cctv_inclusive';
        private $password = 'r.vGf]kh?IN~';
        private $database = 'ibdfohwj_cctv_inclusive';

        public function getConnection(){
            $hostDB = "mysql:host=".$this->host.";dbname=".$this->database.";";

            try{
                $connection = new PDO($hostDB,$this->user,$this->password);
                $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                return $connection;
            } catch(PDOException $e){
                die("ERROR: ".$e->getMessage());
            }

        }
    }


?>