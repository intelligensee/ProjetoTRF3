<?php

require_once 'Dominio.php';

class Usuario extends Dominio {

    private $senha = "";
    private $idCronograma = 0;
    private $cargos = [];

    function getSenha(): string {
        return $this->senha;
    }

    function getIdCronograma(): int {
        return $this->idCronograma;
    }

    function getCargos(): array {
        return $this->cargos;
    }

    function setSenha(string $senha) {
        $this->senha = $senha;
    }

    function setIdCronograma(int $cronograma) {
        $this->idCronograma = $cronograma;
    }

    function setCargos(array $cargos) {
        $this->cargos = $cargos;
    }

}
