<?php

require_once 'Dominio.php';

class Exercicio extends Dominio {

    private $idAssunto;
    private $link = "";

    function getIdAssunto() {
        return $this->idAssunto;
    }

    function getLink(): string {
        return $this->link;
    }

    function setIdAssunto($idAssunto) {
        $this->idAssunto = $idAssunto;
    }

    function setLink(string $link) {
        $this->link = $link;
    }

}
