<?php

require_once (__ROOT__ . '/interfaces/IDAO.php');
require_once (__ROOT__ . '/util/ConnectionFactory.php');
require_once (__ROOT__ . '/dominio/Disciplina.php');
require_once (__ROOT__ . '/dominio/Assunto.php');

class DisciplinaDAO implements IDAO {

    private $conn;

    function __construct() {
        $this->conn = ConnectionFactory::getMySQLConnection();
    }

    public function atualizar($objeto) {
        
    }

    public function excluir($objeto) {
        
    }

    public function pesquisar($objeto) {
        $id = $objeto->getId();
        $sql = "SELECT * FROM disciplina";
        if ($id > 0) {
            $sql .= " WHERE idDisciplina = " . $id;
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rs as $obj) {
            $o = new Disciplina();
            $o->setId($obj["idDisciplina"]);
            $o->setNome($obj["nomeDisciplina"]);
            $list[] = $o;
        }
        return $list;
    }

    public function salvar($objeto) {
        
    }

}
