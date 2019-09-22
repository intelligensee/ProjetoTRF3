<?php

require_once (__ROOT__ . '/interfaces/IFachada.php');
require_once (__ROOT__ . '/strategies/VerificaNome.php');
require_once (__ROOT__ . '/strategies/VerificaSenha.php');
require_once (__ROOT__ . '/strategies/MontaCronograma.php');
require_once (__ROOT__ . '/util/Auxiliar.php');
require_once (__ROOT__ . '/dominio/Cargo.php');
require_once (__ROOT__ . '/daos/UsuarioDAO.php');
require_once (__ROOT__ . '/daos/DisciplinaDAO.php');
require_once (__ROOT__ . '/daos/AssuntoDAO.php');
require_once (__ROOT__ . '/daos/VideoDAO.php');
require_once (__ROOT__ . '/daos/ExercicioDAO.php');
require_once (__ROOT__ . '/daos/JogoDAO.php');
require_once (__ROOT__ . '/daos/CronogramaDAO.php');
require_once (__ROOT__ . '/daos/TarefaDAO.php');
require_once (__ROOT__ . '/daos/CargoDAO.php');

class Fachada implements IFachada {

    private $mapaClasses;

    function __construct() {
        //Lista de regras do comando SALVAR da classe Usuario
        $usuarioSalvar[] = new VerificaNome();
        $usuarioSalvar[] = new VerificaSenha();

        //Lista de regras do comando PESQUISAR da classe Auxiliar
        $auxiliarPesquisar[] = new MontaCronograma();

        //Mapa de comandos da classe Usuario
        $mapaUsuario["SALVAR"] = $usuarioSalvar;

        //Mapa de comandos da classe Auxiliar
        $mapaAuxiliar["PESQUISAR"] = $auxiliarPesquisar;

        //Mapa Geral de Classes
        $this->mapaClasses[get_class(new Usuario())] = $mapaUsuario;
        $this->mapaClasses[get_class(new Auxiliar())] = $mapaAuxiliar;
    }

    public function atualizar($objeto) {
        $retorno[] = $this->executarRegras("ATUALIZAR", $objeto);
        if (empty($retorno[0])) {
            $retorno[] = $this->instanciarDAO($objeto)->atualizar($objeto);
        }
        return $retorno;
    }

    public function excluir($objeto) {
        $retorno[] = $this->executarRegras("EXCLUIR", $objeto);
        if (empty($retorno[0])) {
            $retorno[] = $this->instanciarDAO($objeto)->excluir($objeto);
        }
        return $retorno;
    }

    public function pesquisar($objeto) {
        $retorno[] = $this->executarRegras("PESQUISAR", $objeto);
        if (empty($retorno[0])) {
            $retorno[] = $this->instanciarDAO($objeto)->pesquisar($objeto);
        }
        return $retorno;
    }

    public function salvar($objeto) {
        $retorno[0] = $this->executarRegras("SALVAR", $objeto);
        if (empty($retorno[0])) {//sem erros nas regras de negócio
            $retorno[1] = $this->instanciarDAO($objeto)->salvar($objeto);
            if ($retorno[1][0] === '%ERRO%') {//erro de DAO
                $retorno[0] = $retorno[1];//[0] = espaço para erros
                $retorno[1] = null;//elimina o espaço do DAO
            }
        }
        return $retorno;
    }

    private function executarRegras($comando, $objeto) {
        $verif = null;
        error_reporting(0); //não mostra erros para o usuário
        try {//Verifica a existência de regras de negócio para o objeto recebido
            if (!$m = $this->mapaClasses[get_class($objeto)]) {
                throw new Exception; //lança exceção se não houver
            }
            if (!$r = $m[$comando]) {//Verifica a existência de regras para o comando recebido
                throw new Exception; //lança exceção se não houver
            }
            //Executa as regras de negócio para o objeto e o comando recebidos
            foreach ($r as $regra) {
                if (!empty($verif)) {
                    $verif .= '?' . $regra->verificar($objeto);
                } else {
                    $verif = $regra->verificar($objeto);
                }
            }
            return $verif;
        } catch (Exception $ex) {
            return null;
        }
    }

    private function instanciarDAO($object) {
        $mapaDAO[get_class(new Usuario())] = new UsuarioDAO();
        $mapaDAO[get_class(new Disciplina())] = new DisciplinaDAO();
        $mapaDAO[get_class(new Assunto())] = new AssuntoDAO();
        $mapaDAO[get_class(new Video())] = new VideoDAO();
        $mapaDAO[get_class(new Exercicio())] = new ExercicioDAO();
        $mapaDAO[get_class(new Jogo())] = new JogoDAO();
        $mapaDAO[get_class(new Cronograma())] = new CronogramaDAO();
        $mapaDAO[get_class(new Tarefa())] = new TarefaDAO();
        $mapaDAO[get_class(new Cargo())] = new CargoDAO();

        return $mapaDAO[get_class($object)];
    }

}
