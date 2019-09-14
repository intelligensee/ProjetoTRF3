<?php

require_once (__ROOT__ . '/interfaces/IDAO.php');
require_once (__ROOT__ . '/util/ConnectionFactory.php');
require_once (__ROOT__ . '/dominio/Disciplina.php');
require_once (__ROOT__ . '/dominio/Assunto.php');

class CargoDAO implements IDAO {

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
        $sql = "SELECT * FROM cargo";
        if ($id > 0) {
            $sql .= " WHERE idCargo = " . $id;
        }
        $sql .= " ORDER BY idCargo";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rs as $obj) {
            $o = new Cargo();
            $o->setId($obj["idCargo"]);
            $o->setNome($obj["nomeCargo"]);
            $list[] = $o;
        }
        return $list;
    }

    public function salvar($objeto) {
        
    }

}
