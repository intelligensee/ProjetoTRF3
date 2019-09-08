<?php

require_once (__ROOT__ . '/interfaces/IDAO.php');
require_once (__ROOT__ . '/util/ConnectionFactory.php');
require_once (__ROOT__ . '/dominio/Assunto.php');

class AssuntoDAO implements IDAO {

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
        $idD = $objeto->getIdDisciplina();
        $sql = "SELECT * FROM assunto";
        if ($id > 0) {
            $sql .= " WHERE idAssunto = " . $id;
        } else if ($idD > 0) {
            $sql .= " WHERE idDisciplina = " . $idD;
            $sql .= " ORDER BY sequencia";
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rs as $obj) {
            $o = new Assunto();
            if ($idD > 0) {
                $o->setId($obj["idAssunto"]);
            }
            $o->setNome($obj["nomeAssunto"]);
            $o->setIdDisciplina($obj['idDisciplina']);
            $list[] = $o;
        }
        return $list;
    }

    public function salvar($objeto) {
        
    }

}
