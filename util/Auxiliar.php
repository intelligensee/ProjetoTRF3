<?php

require_once (__ROOT__ . '/controllers/Controller.php');
require_once (__ROOT__ . '/util/DisciplinaAux.php');
require_once (__ROOT__ . '/dominio/Assunto.php');

class Auxiliar {

    private $cargos;
    private $conteudo = false;

    function __construct() {
        
    }

    private function definirCargos() {
        //Obter a lista de cargos
        $c = new Controller();
        $ops = $_SESSION['cargos'];
        $r = $c->processar("PESQUISAR", new Cargo());
        $lista = $r[1];

        //Definir os cargos escolhidos pelo usuário
        for ($i = 0; $i < count($lista); $i++) {//cada cargo cadastrado
            if ($ops[$i]) {//se escolheu este cargo
                $this->cargos[] = $lista[$i]; //insere no array
                $this->conteudo = true; //houve alguma escolha
            }
        }
    }

    public function getTotalAssuntos(): int {
        $c = new Controller();
        $a = new Assunto();
        if ($this->conteudo) {//se houve escolhas
            $a->setCargos($this->cargos); //insere em assunto
        }
        $ra = $c->processar("PESQUISAR", $a);
        //retorna o total de assuntos (todas as disciplinas dos cargos somadas)
        return count($ra[1]);
    }

    public function getDisciplinas(): array {
        $c = new Controller();
        $di = new Disciplina();

        $this->definirCargos(); //define os cargos escolhidos pelo usuário

        if ($this->conteudo) {//se houve escolhas
            $di->setCargos($this->cargos); //insere em disciplina
        }

        //Obter todas as disciplinas
        $rd = $c->processar("PESQUISAR", $di);
        $d = $rd[1]; //todas as disciplinas dos cargos escolhidos
        //Obter todos os assuntos de cada disciplina
        foreach ($d as $dis) {
            $dd[0] = $dis;
            $da = new DisciplinaAux($this->getTotalAssuntos());
            $a = new Assunto();
            if ($this->conteudo) {//se houve escolhas
                $a->setCargos($this->cargos); //insere em assunto
            }
            $a->setIdDisciplina($dis->getId());
            $ra = $c->processar("PESQUISAR", $a);
            $dd[1] = $ra[1]; //todos os assuntos da disciplina #
            $da->setAssuntos($dd); //inserir os assuntos no objeto
            $disciplinas[] = $da; //inserir o objeto na variável
        }

        return $disciplinas; //retorna as lista de disciplinas (DisciplinaAux)
    }

}
