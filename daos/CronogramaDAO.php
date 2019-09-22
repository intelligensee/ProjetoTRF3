<?php

require_once (__ROOT__ . '/interfaces/IDAO.php');
require_once (__ROOT__ . '/util/ConnectionFactory.php');
require_once (__ROOT__ . '/dominio/Usuario.php');
require_once (__ROOT__ . '/dominio/Cargo.php');
require_once (__ROOT__ . '/dominio/Cronograma.php');
require_once (__ROOT__ . '/dominio/Tarefa.php');
require_once (__ROOT__ . '/dominio/Assunto.php');

class CronogramaDAO implements IDAO {

    private $conn;
    private $usuario;
    private $erro = ['%ERRO%', 'CronogramaDAO'];

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
        //Desvincular o usuário dos cargos escolhidos
        $sqlCg = 'DELETE FROM usuario_cargo WHERE idUsuario = ?';
        $stmtCg = $this->conn->prepare($sqlCg);
        $stmtCg->bindParam(1, $idUser);
        $stmtCg->execute();
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
        $cargos = unserialize('cargos');
        $data = new DateTime();
        $mes = $data->format('M');
        $dt = $data->format('dmYHisu');
        $nome = $mes . rand() . $dt;

        $this->conn->beginTransaction(); //desativa o autocommit
        //Salva o novo cronograma
        try {
            $sqlC1 = "INSERT INTO cronograma VALUES (0, ?)";
            $stmtC1 = $this->conn->prepare($sqlC1);
            $stmtC1->bindParam(1, $nome);
            $stmtC1->execute();
        } catch (PDOException $exc) {
            $this->erro[2] = 'Salvar cronograma';
            $this->erro[3] = $exc->getMessage();
            $this->conn->rollBack(); //desfaz as transações
            return $this->erro;
        }

        //Recupera o id do novo cronograma salvo
        try {
            $sqlC2 = "SELECT idCronograma from cronograma WHERE nomeCronograma = ?";
            $stmtC2 = $this->conn->prepare($sqlC2);
            $stmtC2->bindParam(1, $nome);
            $stmtC2->execute();
            $rs = $stmtC2->fetchAll(PDO::FETCH_ASSOC);
            if (empty($rs)) {
                throw new PDOException("Id do cronograma não localizado");
            }
            foreach ($rs as $obj) {
                $idCronograma = $obj["idCronograma"];
            }
        } catch (PDOException $exc) {
            $this->erro[2] = 'Recuperar id do cronograma';
            $this->erro[3] = $exc->getMessage();
            $this->conn->rollBack(); //desfaz as transações
            return $this->erro;
        }

        //Vincula o cronograma ao usuário
        try {
            $sqlU = "UPDATE usuario SET idCronograma = ? WHERE idUsuario = ?";
            $stmtU = $this->conn->prepare($sqlU);
            $stmtU->bindParam(1, $idCronograma);
            $stmtU->bindParam(2, $idUsuario);
            $stmtU->execute();
        } catch (PDOException $exc) {
            $this->erro[] = 'Vincular cronograma ao usuário';
            $this->erro[] = $exc->getMessage();
            $this->conn->rollBack(); //desfaz as transações
            return $this->erro;
        }

        //Salva as tarefas do cronograma
        try {
            $sqlT = "INSERT INTO tarefa VALUES (0, ?, ?, ?, ?)";
            $stmtT = $this->conn->prepare($sqlT);
            foreach ($tarefas as $t) {
                $dataT = $t->getData();
                $status = $t->getStatus();
                $idAssunto = $t->getAssunto()->getId();

                $stmtT->bindParam(1, $dataT);
                $stmtT->bindParam(2, $status);
                $stmtT->bindParam(3, $idAssunto);
                $stmtT->bindParam(4, $idCronograma);
                $stmtT->execute();
            }
        } catch (PDOException $exc) {
            $this->erro[] = 'Inserir tarefas';
            $this->erro[] = $exc->getMessage();
            $this->conn->rollBack(); //desfaz as transações
            return $this->erro;
        }

        //Obtem a lista de cargos
        try {
            $c = new Controller();
            $ops = $_SESSION['cargos'];
            if(empty($ops)){
                throw new PDOException('Erro na session cargos');
            }
            $r = $c->processar("PESQUISAR", new Cargo());
            $lista = $r[1];
            if(empty($lista)){
                throw new PDOException('Lista de cargos vazia');
            }
            //Define os cargos escolhidos pelo usuário
            for ($i = 0; $i < count($lista); $i++) {//cada cargo cadastrado
                if ($ops[$i]) {//se escolheu este cargo
                    $cargos[] = $lista[$i]; //insere no array
                }
            }
            //Vicula o usuário aos cargos escolhidos
            try {
                $sqlCg = "INSERT INTO usuario_cargo VALUES (?, ?)";
                $stmtCg = $this->conn->prepare($sqlCg);
                foreach ($cargos as $cg) {
                    $idC = $cg->getId();
                    $stmtCg->bindParam(1, $idUsuario);
                    $stmtCg->bindParam(2, $idC);
                    $stmtCg->execute();
                }
            } catch (PDOException $exc) {
                $this->erro[] = 'Vincular o usário aos cargos';
                $this->erro[] = $exc->getMessage();
                $this->conn->rollBack(); //desfaz as transações
                return $this->erro;
            }
        } catch (PDOException $exc) {
            $this->erro[] = 'Obeter a lista de cargos';
            $this->erro[] = $exc->getMessage();
            $this->conn->rollBack(); //desfaz as transações
            return $this->erro;
        }
        try {
            $this->conn->commit(); //salva as alterações
        } catch (Exception $exc) {
            $erro[] = '%ERRO%';
            $erro[] = 'CronogramaDAO';
            $erro[] = 'Finalizar';
            $erro[] = $exc->getMessage();
            $this->conn->rollBack(); //desfaz as transações
            return $erro;
        }
    }

}
