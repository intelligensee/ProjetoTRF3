<?php

session_start();
//setlocale(LC_ALL, 'pt_BR');
//date_default_timezone_set('America/Sao_Paulo');
//$q = $_REQUEST["q"];
require_once '../controllers/Controller.php';
$c = new Controller();

require_once '../util/Auxiliar.php';

$r = $c->processar("PESQUISAR", new Auxiliar());

foreach ($r[0] as $o){
    echo $o->getNomeDisciplina();
    echo '</br>';
}

