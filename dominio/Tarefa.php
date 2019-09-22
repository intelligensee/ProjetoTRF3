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

    function getNomeDisciplina(): string {
        return $this->nomeDisciplina;
    }

    function getAssunto(): Assunto {
        return $this->assunto;
    }

    function getStatus(): int {
        if ($this->status) {
            return 1;
        } else {
            return 0;
        }
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
