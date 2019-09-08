<?php

require_once 'Dominio.php';

class Cronograma extends Dominio {

    private $dataIni;
    private $quantidade = 1;
    private $domingo = true;
    private $segunda = true;
    private $terca = true;
    private $quarta = true;
    private $quinta = true;
    private $sexta = true;
    private $sabado = true;
    private $tarefas;

    function getDataIni() {
        return $this->dataIni;
    }

    function getQuantidade(): int {
        return $this->quantidade;
    }

    function isDomingo(): bool {
        return $this->domingo;
    }

    function isSegunda(): bool {
        return $this->segunda;
    }

    function isTerca(): bool {
        return $this->terca;
    }

    function isQuarta(): bool {
        return $this->quarta;
    }

    function isQuinta(): bool {
        return $this->quinta;
    }

    function isSexta(): bool {
        return $this->sexta;
    }

    function isSabado(): bool {
        return $this->sabado;
    }

    function getTarefas(): array {
        return $this->tarefas;
    }

    function setDataIni($dataIni) {
        $this->dataIni = $dataIni;
    }

    function setQuantidade(int $quantidade) {
        $this->quantidade = $quantidade;
    }

    function setDomingo(bool $domingo) {
        $this->domingo = $domingo;
    }

    function setSegunda(bool $segunda) {
        $this->segunda = $segunda;
    }

    function setTerca(bool $terca) {
        $this->terca = $terca;
    }

    function setQuarta(bool $quarta) {
        $this->quarta = $quarta;
    }

    function setQuinta(bool $quinta) {
        $this->quinta = $quinta;
    }

    function setSexta(bool $sexta) {
        $this->sexta = $sexta;
    }

    function setSabado(bool $sabado) {
        $this->sabado = $sabado;
    }

    function setTarefas(array $tarefas) {
        $this->tarefas = $tarefas;
    }

}
