<?php

session_start();
setlocale(LC_ALL, 'pt_BR');
date_default_timezone_set('America/Sao_Paulo');
require_once '../controllers/Controller.php';
require_once '../dominio/Cronograma.php';
require_once '../dominio/Tarefa.php';
require_once '../dominio/Usuario.php';

$q = $_REQUEST['q'];

$act = explode('?', $q); //separa as informações passadas em 'q'
//act[0] = ação a ser executada
//act[1] = dados da ação, se for o caso

switch ($act[0]) {
    case 'load'://carregar cronograma
        carregarCronograma();
        break;
    case 'alt'://alterar parâmetros
        alterar($act[1]);
        break;
    case 'opr'://salvar ou excluir o cronograma
        salvarExcluir($act[1]);
        break;
    default :
        echo 'Execução não definida!';
}

function carregarCronograma() {//Carrega o cronograma salvo ou monta um novo
    //Inicialização das variáveis
    $idCronograma = 0;
    $resposta[0] = 'Olá visitante!';
    $salvo = false; //sem cronograma
    $dias = [true, true, true, true, true, true, true]; //dias da semana padrão
    $qtd = 1;//assuntos por dia padrão
    //Verificação de usuário logado
    if (isset($_SESSION['usuario']) && $_SESSION['usuario'] !== null) {//Se estiver logado
        $u = unserialize($_SESSION['usuario']); //recupera o usuário
        $nome = $u->getNome();
        $resposta[0] = 'Olá ' . $nome . '!';
        $idCronograma = $u->getIdCronograma();
        if ($idCronograma > 0) {//possui cronograma salvo
            $c = new Controller();
            $crono = new Cronograma();
            $crono->setId($idCronograma);
            $r = $c->processar('PESQUISAR', $crono);
            $_SESSION['cronograma'] = serialize($r[1][0]);
            $salvo = true;
        }
    }

    //Verificação de cronograma carregado
    if (isset($_SESSION['cronograma']) && $_SESSION['cronograma'] !== null) {//há cronograma
        $cron = unserialize($_SESSION['cronograma']);
        $idCronograma = $cron->getId();
        $tarefas = $cron->getTarefas();
    } else {//não há cronograma -> cria um novo
        require_once '../util/Auxiliar.php';
        $c = new Controller();
        $r = $c->processar("PESQUISAR", new Auxiliar());
        $crono = new Cronograma();
        $tarefas = $r[0]; //nova lista de tarefas
        $crono->setTarefas($tarefas);
        $_SESSION['cronograma'] = serialize($crono);
        $_SESSION['dias'] = $dias; //dias da semana
        $_SESSION['QtdDia'] = $qtd;//assuntos por dia
    }

    $ret = montar($tarefas, $salvo);
    $resposta[2] = $ret[0];
    $resposta[3] = $ret[1];
    $resposta[5] = $ret[2];

    if ($idCronograma === 0) {//não logado ou sem cronograma salvo
        $resposta[0] .= ' Você não possui cronograma salvo.';
        $resposta[1] = date('Y-m-d', strtotime($tarefas[0]->getData()));
        $resposta[4] = false;
        $dias = $_SESSION['dias'];
        $qtd = $_SESSION['QtdDia'];
    } else {//com cronograma salvo
        $resposta[0] .= ' Esse é o cronograma que você salvou.';
        $resposta[4] = true;
    }
    $retorno = $resposta[0] . '?'; //boas vindas
    $retorno .= $resposta[1] . '?'; //data inicial
    $retorno .= $resposta[2] . '?'; //tabela de assuntos
    $retorno .= $resposta[3] . '?'; //data final
    $retorno .= $resposta[4] . '?'; //visibilidades
    $retorno .= $resposta[5] . '?'; //progresso
    $retorno .= $qtd;//assuntos por dia
    foreach ($dias as $d){//dias da semana escolhidos
        $retorno .= '?' . $d;
    }

    echo $retorno;
}

function alterar($dados) {//Altera os parâmetros de montagem do cronograma
    $e = explode('§', $dados); //separa os dados
    $data = new DateTime($e[0]); //data inicial
    $qtd = $e[1]; //quantidade por dia
    $_SESSION['QtdDia'] = $qtd;
    for ($i = 2; $i < count($e); $i++) {//frequência (domingo à sábado)
        $dias[] = $e[$i];
        if($e[$i] === 'true'){//Obs.: o que vem não é booleano, é texto
            $d[] = true;
        }else{
            $d[] = false;
        }
        $_SESSION['dias'] = $d;//dias da semana escolhidos
    }

    //extração do cronograma da session
    $crono = unserialize($_SESSION['cronograma']);
    $tarefas = $crono->getTarefas();

    $j = 0; //controle de tarefas
    while ($j < count($tarefas)) {//enquanto houver assuntos
        $ds = $data->format('w'); //dia da semana (dom = 0)
        if ($dias[$ds] === 'true') {//se for dia de estudo
            for ($i = 0; $i < $qtd; $i++) {//quantidade por dia
                $tarefas[$j++]->setData($data->format('Y-m-d'));
                if ($j >= count($tarefas)) {
                    break;
                }
            }
        }
        $data->add(new DateInterval('P1D')); //adiciona 1 dia
    }

    //devolução do cronograma modificado na session
    $crono->setTarefas($tarefas);
    $_SESSION['cronograma'] = serialize($crono);

    //montagem da tabela com data final e retorno da chamada
    $ret = montar($tarefas, false);
    echo $ret[0] . '?' . $ret[1];
}

function salvarExcluir($op) {//Salva ou Exclui o cronograma
    if (isset($_SESSION['usuario']) && $_SESSION['usuario'] !== null) {//se estiver logado
        if ($op === 'SALVAR') {//Salva o cronograma definido
            $crono = unserialize($_SESSION['cronograma']);
            $c = new Controller();
            $c->processar("SALVAR", $crono);
        } else if ($op === 'EXCLUIR') {//Exclui o cronograma do usuário
            require_once '../dominio/Usuario.php';
            $c = new Controller();
            $crono = new Cronograma();
            $u = unserialize($_SESSION['usuario']); //recupera o usuário
            $crono->setId($u->getIdCronograma()); //informa o cronograma a ser excluído
            $c->processar('EXCLUIR', $crono);
            $_SESSION['cronograma'] = null;
        }
        //Atualiza a session usuário
        $u = unserialize($_SESSION['usuario']);
        $r = $c->processar("PESQUISAR", $u);
        if (!empty($r[1][0])) {//encontrou o usuário
            $u = serialize($r[1][0]);
            $_SESSION['usuario'] = $u;
        } else {//não encontrou o usuário -> desloga
            $_SESSION['usuario'] = null;
            $_SESSION['cronograma'] = null;
        }
        echo true;
    } else {//não logado -> js encaminha para a página de login
        echo false;
    }
}

function montar($tarefas, $salvo) {
    //Montagem do cronograma, progresso e data final, para visualização do usuário
    $progresso = 0;
    $resp[0] = '<table>';
    $resp[0] .= '<thead><tr><th>Data</th><th>Disciplina</th><th>Assunto</th>';
    if ($salvo) {
        $resp[0] .= '<th>Situação</th>';
    }
    $resp[0] .= '</tr></thead>';
    $resp[0] .= '<tbody>';
    foreach ($tarefas as $t) {//recupera cada tarefa da lista
        $data = date('d/m/Y', strtotime($t->getData())); //formata a data
        $disciplina = $t->getNomeDisciplina();
        $assunto = $t->getAssunto()->getNome();
        $resp[0] .= '<tr><td>' . $data . '</td><td>' . $disciplina . '</td><td>' . $assunto . '</td>';
        if ($salvo) {
            $r = verificarStatus($t);
            $resp[0] .= $r[0];
            if ($r[1]) {
                $progresso++;
            }
        }
        $resp[0] .= '</tr>';
    }
    $resp[0] .= '</tbody></table>';
    $resp[1] = $data;
    $resp[2] = intval(($progresso / count($tarefas)) * 100);
    return $resp;
}

function verificarStatus($tarefa) {
    $hoje = date('Y-m-d');
    $data = date('Y-m-d', strtotime($tarefa->getData()));
    if (!$tarefa->getStatus()) {//não concluído
        $situacao[1] = false;
        if ($hoje > $data) {
            $situacao[0] = '<td style="color:red">Atrasado</td>';
        } else {
            $situacao[0] = '<td style="color:blue">Estudar</td>';
        }
    } else {//concluído
        $situacao[1] = true;
        if ($hoje >= $data) {
            $situacao[0] = '<td style="color:green">OK</td>';
        } else {
            $situacao[0] = '<td style="color:green">Adiantado</td>';
        }
    }
    return $situacao;
}
