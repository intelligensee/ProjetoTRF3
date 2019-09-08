<?php

session_start();
setlocale(LC_ALL, 'pt_BR');
date_default_timezone_set('America/Sao_Paulo');
require_once '../controllers/Controller.php';
require_once '../dominio/Cronograma.php';
require_once '../dominio/Tarefa.php';
require_once '../dominio/Usuario.php';
require_once '../dominio/Video.php';
require_once '../dominio/Exercicio.php';
require_once '../dominio/Jogo.php';

$q = $_REQUEST['q'];

$c = new Controller();
if (isset($_SESSION['usuario']) && $_SESSION['usuario'] !== null) {//Verifica se está logado
    $u = unserialize($_SESSION['usuario']);
    $idCronograma = $u->getIdCronograma();
    if ($idCronograma > 0) {//possui cronograma salvo
        $crono = new Cronograma();
        $crono->setId($idCronograma);
        $r = $c->processar('PESQUISAR', $crono);
        $_SESSION['cronograma'] = serialize($r[1][0]);
    } else {
        echo 'SEM CRONOGRAMA';
        return;
    }
} else {
    echo 'NÃO LOGADO';
    return;
}

if (empty($q)) {
    montarTarefa();
} else {
    atualizarStatus();
}

function montarTarefa() {
    $crono = unserialize($_SESSION['cronograma']);
    $tarefas = $crono->getTarefas();
    foreach ($tarefas as $t) {
        if (!$t->getStatus()) {//tarefa não concluída
            $_SESSION['tarefa'] = serialize($t);
            $h = montarHTML($t);
            $h[5] = progresso($tarefas, $t);
            echo $h[0] . '§' . $h[1] . '§' . $h[2] . '§' . $h[3] . '§' . $h[4] . '§' . $h[5];
            return;
        }
    }
    echo 'SEM CRONOGRAMA';
}

function progresso($tarefas, $tarefa) {
    $i = 0; //total de assuntos da disciplina
    $p = 0; //total de assuntos concluídos da disciplina
    foreach ($tarefas as $t) {//loop em todos os assuntos do cronograma
        if ($t->getNomeDisciplina() === $tarefa->getNomeDisciplina()) {
            $i++;
            if ($t->getStatus()) {//assunto concluído
                $p++;
            }
        }
    }
    return intval(($p / $i) * 100);
}

function montarHTML($tarefa) {
    $c = new Controller();
    $html[0] = $tarefa->getNomeDisciplina();
    $html[1] = $tarefa->getAssunto()->getNome();
    $html[2] = montarVideo($tarefa);
    $html[3] = montarExercicio($tarefa);
    $html[4] = montarJogo($tarefa);
    return $html;
}

function montarVideo($tarefa) {
    $c = new Controller();
    $v = new Video();
    $h = '';
    $v->setIdAssunto($tarefa->getAssunto()->getId());
    $rv = $c->processar("PESQUISAR", $v);
    if (!empty($rv[1])) {
        $videos = $rv[1];
        $h = '<ul>';
        foreach ($videos as $vd) {
            $h .= '<li><a href="' . $vd->getLink() . '">' . $vd->getNome() . '</a></li>';
        }
        $h .= '</ul>';
    }
    return $h;
}

function montarExercicio($tarefa) {
    $c = new Controller();
    $e = new Exercicio();
    $h = '';
    $e->setIdAssunto($tarefa->getAssunto()->getId());
    $re = $c->processar("PESQUISAR", $e);
    if (!empty($re[1])) {
        $exercicios = $re[1];
        $h = '<ul>';
        foreach ($exercicios as $exerc) {
            $h .= '<li><a href="' . $exerc->getLink() . '">' . $exerc->getNome() . '</a></li>';
        }
        $h .= '</ul>';
    }
    return $h;
}

function montarJogo($tarefa) {
    $c = new Controller();
    $j = new Jogo();
    $h = '';
    $j->setIdAssunto($tarefa->getAssunto()->getId());
    $rj = $c->processar("PESQUISAR", $j);
    if (!empty($rj[1])) {
        $jogos = $rj[1];
        $h = '<ul>';
        foreach ($jogos as $jg) {
            $h .= '<li><a href="jogos/' . $jg->getCaminho() . '">' . $jg->getNome() . '</a></li>';
        }
        $h .= '</ul>';
    }
    return $h;
}

function atualizarStatus() {
    if (isset($_SESSION['tarefa']) && $_SESSION['tarefa'] !== null) {
        $tarefa = unserialize($_SESSION['tarefa']);
        $c = new Controller();
        $c->processar("ATUALIZAR", $tarefa);
    }
    echo 'OK';
}
