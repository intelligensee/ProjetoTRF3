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
    foreach ($disciplinas[1] as $d) {
        $id = $d->getId();
        $nome = $d->getNome();
        echo '<form method="post" action="disciplina.php?id=' . $id . '">';
        echo '<input type="submit" value="' . $nome . '">';
        echo '</form>';
    }
} else {
    echo "Escolha pelo menos um cargo!";
}






    