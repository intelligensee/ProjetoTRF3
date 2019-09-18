<?php

require_once (__ROOT__ . '/interfaces/IStrategy.php');
require_once (__ROOT__ . '/dominio/Tarefa.php');

class MontaCronograma implements IStrategy {

    private $disciplinas; //lista de objetos util/DisciplinaAux.php
    private $totalAssuntos; //todos os assuntos do curso
    private $posicoes; //array das posições do crongogram (para reserva)

    public function verificar($objeto) {//objeto = util/Auxiliar.php
        $this->disciplinas = $objeto->getDisciplinas();
        $this->totalAssuntos = $objeto->getTotalAssuntos();
        
        $this->ordenar();
        $this->preparar();
        return $this->montar();
    }

    private function ordenar() {
        //Ordena por ordem decrescente de quantidade de assuntos -> método: BubleSort
        for ($i = 0; $i < count($this->disciplinas) - 1; $i++) {
            for ($j = $i + 1; $j < count($this->disciplinas); $j++) {
                if (count($this->disciplinas[$i]->getAssuntos()[1]) < count($this->disciplinas[$j]->getAssuntos()[1])) {
                    $temp = $this->disciplinas[$i];
                    $this->disciplinas[$i] = $this->disciplinas[$j];
                    $this->disciplinas[$j] = $temp;
                }
            }
        }
    }

    private function preparar() {
        //Prepara um índice de posições no cronograma
        for ($i = 0; $i < $this->totalAssuntos; $i++) {
            $this->posicoes[] = null;
        }
    }

    private function montar() {
        //Monta o cronograma
        $contDia = 0; //define a posição do assunto no cronograma
        $i = 0; //define a disciplina da vez
        while ($contDia < $this->totalAssuntos) {//enquanto houver assuntos
            $d = $this->disciplinas[$i]; //disciplina da vez
            $nomeDisc = $d->getAssuntos()[0]->getNome(); //nome da disciplina da vez
            $v = $this->posicoes[$contDia]; //verifica se a posição já está reservada
            $this->posicoes[$contDia] = null; //limpa a posição lida
            if ($v !== null && $v->getAssuntos()[0]->getNome() !== $nomeDisc) {//posição reservada para outra disciplina
                $d = $v; //recupera a disciplina na reserva
            } else {//posição livre
                $i = fmod(++$i, count($this->disciplinas)); //incrementa i, voltando a zero ao atingir o total de disciplinas
            }
            $assunto = $d->getAssunto(); //assunto da vez
            $quantidade = $d->getQuantidade(); //quantidade de assuntos da disciplina
            if ($assunto === $quantidade) {//não há mais assuntos nessa disciplina
                continue; //volta ao início do loop
            }

            $tarefa = new Tarefa(); //cria nova tarefa
            $tarefa->setData(date('Y-m-d', strtotime($contDia . ' days'))); //insere a data da tarefa 
            $tarefa->setNomeDisciplina($d->getAssuntos()[0]->getNome()); //insere o nome da disciplina
            $tarefa->setAssunto($d->getAssuntos()[1][$assunto]); //insere o assunto da vez
            $lista[] = $tarefa; //insere a tarefa no cronograma (lista)
            $d->setEvolucao($d->getEvolucao() + 1); //registra a inclusão de mais um assunto
            $d->setAssunto(++$assunto); //define o próximo assunto da disciplina
            if ($assunto < $quantidade) {//se ainda houver assuntos
                $this->reservarPosicao($d, $contDia); //reserva a posição do próximo assunto da disciplina
            }
            $contDia++; //incrementa a posição no cronograma
        }

        return $lista; //retorna a lista ordenada de tarefas do cronograma
    }

    private function reservarPosicao($d, $contDia) {
        //Reserva a posição do próximo assunto da disciplina no crongograma
        $fator = $d->getFator(); //fator de distribuição de assuntos
        $resto = $d->getResto(); //sobras anteriores do fator (parte decimal)
        $nome = $d->getAssuntos()[0]->getNome(); //nome da disciplina
        $j = intval($fator); //parte inteira do fator
        $pos = $contDia + $j; //posição do próximo assunto desta disciplina
        if ($pos < $this->totalAssuntos) {//se não ultrapassar o total de assuntos
            $resto += $fator - $j; //soma as sobras anteriores à atual
            if ($resto >= 1) {//se a sobra formar um inteiro
                $pos++; //incrementa a posição
                $resto -= intval($resto); //deixa apenas a parte decimal
            }
            $v = $this->posicoes[$pos];
            $this->limparDuplicidades($contDia, $nome);
            if ($v === null) {//posição livre
                $this->posicoes[$pos] = $d; //reserva a posição para essa disciplina
            } else {//posição reservada
                //calcula a evolução percentual das disciplinas
                //assuntos já inseridos dividido pelo total da disciplina
                $percentD = $d->getEvolucao() / $d->getQuantidade();
                $percentV = $v->getEvolucao() / $v->getQuantidade();

                if ($percentD < $percentV) {
                    //prioridade para a disciplina proporcionalmente mais atrasada
                    $this->posicoes[$pos] = $d; //reserva a posição para essa disciplina
                }
            }
        }

    }

    private function limparDuplicidades($pos, $nome) {
        //Limpa as eventuais reservas pré existentes
        for ($i = $pos + 1; $i < count($this->posicoes); $i++) {
            $p = $this->posicoes[$i];
            if ($p !== null) {
                $nm = $p->getAssuntos()[0]->getNome();
                if ($nm === $nome) {
                    $this->posicoes[$i] = null;
                }
            }
        }
    }

}
