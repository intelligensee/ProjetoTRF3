<?php

session_start();
setlocale(LC_ALL, 'pt_BR');
date_default_timezone_set('America/Sao_Paulo');
$q = $_REQUEST["q"];
//require_once '../controllers/Controller.php';
//$c = new Controller();

try {
    $cg = $_SESSION['argos'];
    if(empty($cg)){
        throw new PDOException("Erro");
    }
    echo 'Passou!';
} catch (PDOException $exc) {
    echo $exc->getMessage();
    return;
}

echo 'Fim';

