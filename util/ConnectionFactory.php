<?php

abstract class ConnectionFactory {

    private static $dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

    public static function getMySQLConnection() {
        $pdo = self::TRF3Local();
        //$pdo = self::TRF3AzureMySQLI();
        //$pdo = self::TRF3AzurePDO();

        if ($pdo === null) {
            echo "Não foi possível conectar com o banco!";
        } else {
            return $pdo;
        }
    }

    private static function TRF3Local(): PDO {
        $sql = 'mysql:host=localhost;dbname=id10809310_intelligensee_trf3;charset=utf8';
        $user = 'id10809310_cronotrf3';
        $password = 'itlstrf3';
        $conn = new PDO($sql, $user, $password, self::$dsn_Options);
        return $conn;
    }

    private static function TRF3AzurePDO() {
        $sql = 'mysql:host=trf3crono.mariadb.database.azure.com;port=3306;dbname=trf3';
        $user = "itlsadm@trf3crono";
        $password = "Int3llig3nS33";
        $options = array(PDO::MYSQL_ATTR_SSL_CA => '../BaltimoreCyberTrustRoot.crt.pem', PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        try {
            $conn = new PDO($sql, $user, $password, $options);
            return $conn;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    private static function TRF3AzureMySQLI() {
        $con = mysqli_init();
        $user = "itlsadm@trf3crono";
        $password = "Int3llig3nS33";
        mysqli_ssl_set($con, NULL, NULL, '/BaltimoreCyberTrustRoot.crt.pem', NULL, NULL);
        mysqli_real_connect($con, "trf3crono.mariadb.database.azure.com", $user, $password, 'trf3', 3306);
        if (mysqli_connect_errno($con)) {
            die('Failed to connect to MySQL: ' . mysqli_connect_error());
        } else {
            return $con;
        }
    }

//senha do site WH: trf3itls
//azure senha: 40289653819
}
