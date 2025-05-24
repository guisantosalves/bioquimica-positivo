<?php

class ConnectionFactory
{
    static $connection;
    public static function getConnection()
    {
        if (!isset($connection)) {
            $host = "localhost";
            $dbName = "bioquimica";
            $user = "root";
            $pass = "";
            $port = 3306;

            try {
                $connection = new PDO("mysql:host=$host;dbname=$dbName;port=$port", $user, $pass);
                return $connection;
            } catch (PDOException $ex) {
                echo ("ERRO ao conectar no banco de dados! <p>$ex</p>");

            }
        }
    }
}

?>