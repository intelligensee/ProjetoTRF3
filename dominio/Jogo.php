<?php

require_once 'Dominio.php';

class Jogo extends Dominio {

    private $idAssunto;
    private $caminho;

    function getIdAssunto() {
        return $this->idAssunto;
    }

    function getCaminho() {
        return $this->caminho;
    }

    function setIdAssunto($idAssunto) {
        $this->idAssunto = $idAssunto;
    }

    function setCaminho($caminho) {
        $this->caminho = $caminho;
    }

}
