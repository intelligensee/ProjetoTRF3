<?php

require_once 'Dominio.php';

class Tarefa extends Dominio {

    private $data;
    private $nomeDisciplina = "";
    private $assunto;
    private $status = false;

    function getData() {
        return $this->data;
    }

    function getNomeDisciplina() : string {
        return $this->nomeDisciplina;
    }

    function getAssunto(): Assunto {
        return $this->assunto;
    }

    function getStatus(): bool {
        return $this->status;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setNomeDisciplina(string $nomeDisciplina) {
        $this->nomeDisciplina = $nomeDisciplina;
    }

    function setAssunto(Assunto $assunto) {
        $this->assunto = $assunto;
    }

    function setStatus(bool $status) {
        $this->status = $status;
    }

}
