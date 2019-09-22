<?php

session_start();
require_once '../controllers/Controller.php';
require_once '../dominio/Usuario.php';
require_once '../dominio/Disciplina.php';
$q = $_REQUEST['q'];
$e = explode(',', $q); //cargos escolhidos

$c = new Controller();
$u = new Usuario();
$d = new Disciplina();

$r = $c->processar("PESQUISAR", new Cargo());
$lista = $r[1]; //lista de cargos cadastrados
$conteudo = false;
$op = "";
for ($i = 0; $i < count($lista); $i++) {//cada cargo cadastrado
    if ($i > 0) {
        $op .= '%';
    }
    if ($e[$i + 1] === 'true') {//Obs.: o conteúdo não é booleano, é texto
        $cargos[] = $lista[$i]; //foi escolhido este cargo
        $cg[$i] = true; //escolhido
        $conteudo = true;
        $op .= 't';
    } else {
        $cg[$i] = false; //não escolhido
        $op .= 'f';
    }
}
if ($e[0] === 'true') {//se for proviniente de alteração. Obs.: não é booleano, é texto
    $_SESSION['cargos'] = $cg;
    $_SESSION['cronograma'] = null;
}
if ($conteudo) {
    $d->setCargos($cargos);
    $r = $c->processar("PESQUISAR", $d);
    $disciplinas = $r[1]; //lista de disciplinas
    $resp = "";
    foreach ($disciplinas as $d) {
        $id = $d->getId();
        $nome = $d->getNome();
        $resp .= '<form method="post" action="disciplina.php?id=' . $id . '&ops=' . $op . '">';
        $resp .= '<input class="button" type="Submit" value="' . $nome . '">';
        $resp .= '</form>';
    }
    $resp .= '§' . count($disciplinas) . ' disciplinas';
} else {
    $resp = "Escolha pelo menos um cargo!§";
}

echo $resp;




