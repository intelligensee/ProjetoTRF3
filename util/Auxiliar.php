<?php

require_once (__ROOT__ . '/controllers/Controller.php');
require_once (__ROOT__ . '/util/DisciplinaAux.php');
require_once (__ROOT__ . '/dominio/Assunto.php');

class Auxiliar {

    function getTotalAssuntos(): int {
        $c = new Controller();
        $ra = $c->processar("PESQUISAR", new Assunto());
        return count($ra[1]);//retorna o total de assuntos (todas as disciplinas somadas)
    }

    function getDisciplinas(): array {
        $c = new Controller();

        //Obter todas as disciplinas
        $rd = $c->processar("PESQUISAR", new Disciplina());
        $d = $rd[1]; //todas as disciplinas
        //Obter todos os assuntos de cada disciplina
        foreach ($d as $dis) {
            $dd[0] = $dis;
            $da = new DisciplinaAux($this->getTotalAssuntos());
            $a = new Assunto();
            $a->setIdDisciplina($dis->getId());
            $ra = $c->processar("PESQUISAR", $a);
            $dd[1] = $ra[1]; //todos os assuntos da disciplina #
            $da->setAssuntos($dd); //inserir os assuntos no objeto
            $disciplinas[] = $da; //inserir o objeto na variável
        }
        
        return $disciplinas; //retorna as lista de disciplinas (DisciplinaAux)
    }

}
