<?php

abstract class ConnectionFactory {

    /*public static function getMySQLConnection(): PDO {
        $sql = "mysql:host=localhost;dbname=vestibulinho_etec;charset=utf8";
        $dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        $conn = new PDO($sql, 'root', '', $dsn_Options);
        return $conn;
    }*/

    public static function getMySQLConnectionVEtec(): PDO {
        $sql = "mysql:host=localhost;dbname=id9351912_vestibulinho_etec;charset=utf8";
        $dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        $conn = new PDO($sql, 'id9351912_rsp', '16rsp71VE', $dsn_Options);
        return $conn;
    }
    
    public static function getMySQLConnection(): PDO {
        $sql = "mysql:host=localhost;dbname=id10809310_intelligensee_trf3;charset=utf8";
        $dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        $conn = new PDO($sql, 'id10809310_cronotrf3', 'itlstrf3', $dsn_Options);
        return $conn;
    }
    
    //dbname=id10809310_intelligensee_trf3
    //user=id10809310_cronotrf3
    //senha=itlstrf3
    
    //senha do site=trf3itls
}
