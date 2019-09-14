<?php

session_start();
require_once '../controllers/Controller.php';
require_once '../dominio/Usuario.php';
$q = $_REQUEST['q'];

$c = new Controller();
$u = new Usuario();

if (empty($q)) {//sair
    $_SESSION['usuario'] = null;
    $_SESSION['cronograma'] = null;
    $logado = 'D';//deslogado
} else {//entrar
    $log = explode('?', $q);
    $nome = $log[0];
    $senha = $log[1];
    $u->setNome($nome);
    $u->setSenha($senha);
    $r = $c->processar("PESQUISAR", $u);
    if (!empty($r[1][0])) {//encontrou o usuário
        $u = serialize($r[1][0]);
        $_SESSION['usuario'] = $u;
        $logado = 'L';//logado
    } else {//não encontrou o usuário
        $_SESSION['usuario'] = null;
        $_SESSION['cronograma'] = null;
        $_SESSION['tarefa'] = null;
        $_SESSION['dias'] = null;
        $_SESSION['QtdDia'] = null;
        $logado = 'E';//erro de usuário e/ou senha
    }
}

echo $logado;