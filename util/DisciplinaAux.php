<?php

//classe auxiliar para montagem do cronograma
class DisciplinaAux {

    private $total; //total de assuntos do curso (soma de todas as disciplinas)
    private $assuntos; //todos os assuntos da disciplina
    private $assunto = 0; //índice do assunto a ser inserido no cronograma
    private $fator = 0; //proporção de assuntos da disciplina em relação ao total
    private $evolucao = 0; //quantidade de assuntos já inseridos no cronograma
    private $quantidade = 0; //total de assuntos desta disciplina
    private $resto = 0; //ajuste da proporção de assuntos (parte decimal do fator)

    function __construct($total) {
        $this->total = $total;
    }

    function getAssuntos(): array {
        return $this->assuntos;
    }

    function getAssunto(): int {
        return $this->assunto;
    }

    function getFator(): int {
        return $this->fator;
    }

    function getEvolucao(): int {
        return $this->evolucao;
    }

    function getQuantidade(): int {
        return $this->quantidade;
    }

    function getResto() {
        return $this->resto;
    }

    function setAssuntos(array $assuntos) {
        $this->assuntos = $assuntos;
        $this->quantidade = count($assuntos[1]);
        $this->fator = $this->total / $this->quantidade;
    }

    function setAssunto(int $assunto) {
        $this->assunto = $assunto;
    }

    function setEvolucao(int $evolucao) {
        $this->evolucao = $evolucao;
    }

    function setResto($resto) {
        $this->resto = $resto;
    }

}
