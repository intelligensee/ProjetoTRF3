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
        $cargos = $objeto->getCargos();

        $sql = "SELECT * FROM disciplina";
        if ($id > 0) {
            $sql .= " WHERE idDisciplina = " . $id;
        } else if (!empty($cargos)) {
            $sql .= " JOIN cargo_disciplina";
            $sql .= " ON disciplina.idDisciplina = cargo_disciplina.idDisciplina";
            $sql .= " JOIN cargo";
            $sql .= " ON cargo_disciplina.idCargo = cargo.idCargo";

            for ($i = 0; $i < count($cargos); $i++) {
                $idC = $cargos[$i]->getId();
                if ($i === 0) {
                    $sql .= " WHERE";
                } else {
                    $sql .= " OR";
                }
                $sql .= " cargo.idCargo = " . $idC;
            }
        }
        $sql .= " GROUP BY disciplina.idDisciplina";

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
