<?php

require_once (__ROOT__ . '/interfaces/IDAO.php');
require_once (__ROOT__ . '/util/ConnectionFactory.php');
require_once (__ROOT__ . '/dominio/Usuario.php');
require_once (__ROOT__ . '/dominio/Cronograma.php');
require_once (__ROOT__ . '/dominio/Tarefa.php');
require_once (__ROOT__ . '/dominio/Assunto.php');

class CronogramaDAO implements IDAO {

    private $conn;
    private $usuario;

    function __construct() {
        $this->conn = ConnectionFactory::getMySQLConnection();
        if (isset($_SESSION['usuario'])) {
            $this->usuario = unserialize($_SESSION['usuario']);
        }
    }

    public function atualizar($objeto) {
        
    }

    public function excluir($objeto) {
        $idCron = $objeto->getId();
        $idUser = $this->usuario->getId();
        //Apagar as tarefas do cronograma
        $sqlT = 'DELETE FROM tarefa WHERE idCronograma = ?';
        $stmtT = $this->conn->prepare($sqlT);
        $stmtT->bindParam(1, $idCron);
        $stmtT->execute();
        //Desvincular o usuário do cronograma
        $sqlU = 'UPDATE usuario SET idCronograma = NULL WHERE idUsuario = ?;';
        $stmtU = $this->conn->prepare($sqlU);
        $stmtU->bindParam(1, $idUser);
        $stmtU->execute();
        //Apagar cronograma
        $sqlC = 'DELETE FROM cronograma WHERE idCronograma = ?';
        $stmtC = $this->conn->prepare($sqlC);
        $stmtC->bindParam(1, $idCron);
        $stmtC->execute();
    }

    public function pesquisar($objeto) {
        $id = $objeto->getId();
        $sql = 'SELECT idTarefa, data, status, tarefa.idAssunto, nomeDisciplina, nomeAssunto';
        $sql .= ' FROM tarefa JOIN assunto ON tarefa.idAssunto = assunto.idAssunto';
        $sql .= ' JOIN disciplina ON assunto.idDisciplina = disciplina.idDisciplina';
        $sql .= ' JOIN cronograma ON tarefa.idCronograma = cronograma.idCronograma';
        $sql .= ' WHERE cronograma.idCronograma = ? ORDER BY idTarefa';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rs as $obj) {
            $o = new Tarefa();
            $o->setId($obj['idTarefa']);
            $o->setData($obj['data']);
            $o->setStatus($obj['status']);
            $a = new Assunto();
            $a->setId($obj['idAssunto']);
            $a->setNome($obj['nomeAssunto']);
            $o->setAssunto($a);
            $o->setNomeDisciplina($obj['nomeDisciplina']);
            $tarefas[] = $o;
        }
        $objeto->setTarefas($tarefas);
        $list[0] = $objeto;
        return $list;
    }

    public function salvar($objeto) {
        setlocale(LC_ALL, 'pt_BR');
        date_default_timezone_set('America/Sao_Paulo');
        $tarefas = $objeto->getTarefas();
        $idUsuario = $this->usuario->getId();
        $data = new DateTime();
        $mes = $data->format('M');
        $dt = $data->format('dmYHisu');
        $nome = $mes . rand() . $dt;

        //Salva o novo cronograma
        $sqlC1 = "INSERT INTO cronograma VALUES (0, ?)";
        $stmtC1 = $this->conn->prepare($sqlC1);
        $stmtC1->bindParam(1, $nome);
        $stmtC1->execute();
        
        //Recupera o id do novo cronograma salvo
        $sqlC2 = "SELECT idCronograma from cronograma WHERE nomeCronograma = ?";
        $stmtC2 = $this->conn->prepare($sqlC2);
        $stmtC2->bindParam(1, $nome);
        $stmtC2->execute();
        $rs = $stmtC2->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rs as $obj) {
            $idCronograma = $obj["idCronograma"];
        }
        
        //Vincula o cronograma ao usuário
        $sqlU = "UPDATE usuario SET idCronograma = ? WHERE idUsuario = ?";
        $stmtU = $this->conn->prepare($sqlU);
        $stmtU->bindParam(1, $idCronograma);
        $stmtU->bindParam(2, $idUsuario);
        $stmtU->execute();
        
        //Salva as tarefas do cronograma
        $sqlT = "INSERT INTO tarefa VALUES (0, ?, ?, ?, ?)";
        $stmtT = $this->conn->prepare($sqlT);
        foreach ($tarefas as $t) {
            $data = $t->getData();
            $status = $t->getStatus();
            $idAssunto = $t->getAssunto()->getId();

            $stmtT->bindParam(1, $data);
            $stmtT->bindParam(2, $status);
            $stmtT->bindParam(3, $idAssunto);
            $stmtT->bindParam(4, $idCronograma);
            $stmtT->execute();
        }
        return true;
    }

}
