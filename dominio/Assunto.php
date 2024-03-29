<?php

require_once 'Dominio.php';

class Assunto extends Dominio {

    private $idDisciplina = 0;
    private $cargos = [];
    private $exercicios;
    private $videos;
    private $jogos;

    function getIdDisciplina(): int {
        return $this->idDisciplina;
    }

    function getCargos() : array {
        return $this->cargos;
    }

    function getExercicios(): array {
        return $this->exercicios;
    }

    function getVideos(): array {
        return $this->videos;
    }

    function getJogos(): array {
        return $this->jogos;
    }

    function setIdDisciplina(int $idDisciplina) {
        $this->idDisciplina = $idDisciplina;
    }

    function setCargos(array $cargos) {
        $this->cargos = $cargos;
    }

    function setExercicios(array $exercicios) {
        $this->exercicios = $exercicios;
    }

    function setVideos(array $videos) {
        $this->videos = $videos;
    }

    function setJogos(array $jogos) {
        $this->jogos = $jogos;
    }

}
