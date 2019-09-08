<?php

require_once 'Dominio.php';

class Usuario extends Dominio {

    private $senha = "";
    private $idCronograma = 0;

    function getSenha() : string{
        return $this->senha;
    }

    function getIdCronograma(): int {
        return $this->idCronograma;
    }

    function setSenha(string $senha) {
        $this->senha = $senha;
    }

    function setIdCronograma(int $cronograma) {
        $this->idCronograma = $cronograma;
    }

}
