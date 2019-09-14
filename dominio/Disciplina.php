<?php

require_once 'Dominio.php';

class Disciplina extends Dominio {

    private $cargos = [];

    function getCargos() : array{
        return $this->cargos;
    }

    function setCargos(array $cargos) {
        $this->cargos = $cargos;
    }

}
