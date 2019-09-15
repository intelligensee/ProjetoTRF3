<?php

session_start();
require_once '../controllers/Controller.php';
require_once '../dominio/Usuario.php';
require_once '../dominio/Disciplina.php';
$q = $_REQUEST['q'];
$e = explode(',', $q);

$c = new Controller();
$u = new Usuario();
$d = new Disciplina();

$r = $c->processar("PESQUISAR", new Cargo());
$lista = $r[1]; //lista de cargos cadastrados
$conteudo = false;
for ($i = 0; $i < count($lista); $i++) {//cada cargo cadastrado
    if ($e[$i] === 'true') {//Obs.: o conteúdo não é booleano, é texto
        $cargos[] = $lista[$i]; //foi escolhido este cargo
        $conteudo = true;
    }
}
if ($conteudo) {
    $d->setCargos($cargos);
    $r = $c->processar("PESQUISAR", $d);
    $disciplinas = $r[1];//lista de disciplinas
    $resp = "";
    foreach ($disciplinas as $d) {
        $id = $d->getId();
        $nome = $d->getNome();
        $resp .= '<form method="post" action="disciplina.php?id=' . $id . '">';
        $resp .=  '<input type="submit" value="' . $nome . '">';
        $resp .= '</form>';
    }
    $resp .= '§' . count($disciplinas) . ' disciplinas';
} else {
    $resp = "Escolha pelo menos um cargo!§";
}

echo $resp;




    