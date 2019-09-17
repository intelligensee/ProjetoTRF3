<?php

session_start();
require_once '../controllers/Controller.php';
require_once '../dominio/Usuario.php';
require_once '../dominio/Cargo.php';

if (isset($_SESSION['usuario']) && $_SESSION['usuario'] !== null) {//logado
    $u = unserialize($_SESSION['usuario']); //recupera o usuário
    $cg = $u->getCargos(); //cargos do usuário

    $c = new Controller();
    $r = $c->processar("PESQUISAR", new Cargo()); //recupera a lista de cargos
    $lista = $r[1]; //lista de cargos cadastrados
    $controle = false;//controle de escolhas
    for ($i = 0; $i < count($lista); $i++) {//cada cargo cadastrado
        $cargos[$i] = false; //não escolhido (padrão)
        foreach ($cg as $o) {//cada cargo do usuário
            if ($lista[$i]->getId() == $o->getId()) {//o usuário escolheu este cargo
                $cargos[$i] = true;
                $controle = true;//houve pelo menos uma escolha
                continue; //sai do loop dos cargos do usuário
            }
        }
    }
    $_SESSION['cargos'] = $cargos;
    $retorno = true;//logado
    $rt = '?';
    for ($i = 0; $i < count($cargos); $i++) {
        if($i > 0){
            $rt .= '§';
        }
        $rt .= $cargos[$i];
    }
    echo $retorno . $rt . '?' . $controle;
} else {//não logado
    echo false;
}