<?php

abstract class ConnectionFactory {

    /*public static function getMySQLConnection(): PDO {
        $sql = "mysql:host=localhost;dbname=vestibulinho_etec;charset=utf8";
        $dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        $conn = new PDO($sql, 'root', '', $dsn_Options);
        return $conn;
    }*/

    public static function getMySQLConnection(): PDO {
        $sql = "mysql:host=localhost;dbname=id9351912_vestibulinho_etec;charset=utf8";
        $dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        $conn = new PDO($sql, 'id9351912_rsp', '16rsp71VE', $dsn_Options);
        return $conn;
    }
}
