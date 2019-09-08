<?php

abstract class Dominio {

    private $id = 0;
    private $nome = "";

    function getId(): int {
        return $this->id;
    }

    function getNome(): string {
        return $this->nome;
    }

    function setId(int $id) {
        $this->id = $id;
    }

    function setNome(string $nome) {
        $this->nome = $nome;
    }

}
