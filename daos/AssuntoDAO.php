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
        $idC = $objeto->getId();
        $idD = $objeto->getIdDisciplina();
        $cargos = $objeto->getCargos();
        
        $sql = "SELECT assunto.idAssunto, nomeAssunto, idDisciplina";
        $sql .= " FROM assunto";

        if (!empty($cargos)) {//assuntos específicos de certos cargos
            $sql .= " JOIN cargo_assunto";
            $sql .= " ON assunto.idAssunto = cargo_assunto.idAssunto";
            $sql .= " JOIN cargo";
            $sql .= " ON cargo_assunto.idCargo = cargo.idCargo";
            for ($i = 0; $i < count($cargos); $i++) {
                $id = $cargos[$i]->getId();
                if ($i === 0) {
                    $sql .= " WHERE (";
                } else {
                    $sql .= " OR";
                }
                $sql .= " cargo.idCargo = " . $id;
            }
            $sql .= ")";
        } else if ($idC > 0) {//um assunto específico
            $sql .= " WHERE idAssunto = " . $idC;
        }
        if ($idD > 0) {//uma disciplina específica
            if (!empty($cargos)) {
                $sql .= " AND";
            } else {
                $sql .= " WHERE";
            }
            $sql .= " idDisciplina = " . $idD;
        }

        $sql .= " GROUP BY idAssunto";
        $sql .= " ORDER BY sequencia";

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
