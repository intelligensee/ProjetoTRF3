<?php

session_start();
//setlocale(LC_ALL, 'pt_BR');
//date_default_timezone_set('America/Sao_Paulo');
//$q = $_REQUEST["q"];
require_once '../controllers/Controller.php';
$c = new Controller();
//require_once '../dominio/Usuario.php';
//require_once '../dominio/Cargo.php';
require_once '../dominio/Assunto.php';
$a = new Assunto();

$ops = $_SESSION['cargos'];
$r = $c->processar("PESQUISAR", new Cargo());
$lista = $r[1];

//Definir os cargos escolhidos pelo usuário
for ($i = 0; $i < count($lista); $i++) {//cada cargo cadastrado
    if ($ops[$i]) {//se escolheu este cargo
        $cargos[] = $lista[$i]; //insere no array
    }
}

$a->setCargos($cargos);
$as = $c->processar("PESQUISAR", $a);

echo count($as[1]);
