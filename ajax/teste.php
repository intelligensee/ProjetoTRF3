<?php

session_start();
//setlocale(LC_ALL, 'pt_BR');
//date_default_timezone_set('America/Sao_Paulo');
//$q = $_REQUEST["q"];
require_once '../controllers/Controller.php';
$c = new Controller();

require_once '../dominio/Usuario.php';
//require_once '../dominio/Cargo.php';

$u1 = new Usuario();
$u1->setId(3);

$r = $c->processar("PESQUISAR", $u1);
$u = $r[1][0];

echo "<pre>";
print_r($u);

$cg = $u->getCargos();
print_r($cg);


