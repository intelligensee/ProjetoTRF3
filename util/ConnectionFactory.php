<?php

abstract class ConnectionFactory {

    private static $dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

    public static function getMySQLConnection(): PDO {
        //return self::TRF3Local();
        return self::TRF3Azure();
    }

    private static function TRF3Local(): PDO {
        $sql = 'mysql:host=localhost;dbname=id10809310_intelligensee_trf3;charset=utf8';
        $user = 'id10809310_cronotrf3';
        $password = 'itlstrf3';
        $conn = new PDO($sql, $user, $password, self::$dsn_Options);
        return $conn;
    }

    private static function TRF3Azure(): PDO {
        $sql = 'mysql:host=trf3crono.mariadb.database.azure.com;port=3306;dbname=trf3';
        $user = "itlsadm@trf3crono";
        $password = "Int3llig3nS33";
        $options = array(PDO::MYSQL_ATTR_SSL_CA => 'C:/BaltimoreCyberTrustRoot.crt.pem');
        return new PDO($sql, $user, $password, $options);
    }

    //senha do site WH: trf3itls
    //azure senha: 40289653819
}
