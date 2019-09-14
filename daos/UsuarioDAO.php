<?php

require_once (__ROOT__ . '/interfaces/IDAO.php');
require_once (__ROOT__ . '/util/ConnectionFactory.php');
require_once (__ROOT__ . '/dominio/Usuario.php');
require_once (__ROOT__ . '/dominio/Cargo.php');

class UsuarioDAO implements IDAO {

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
        $nome = $objeto->getNome();
        $senha = $objeto->getSenha();
        $sql = "SELECT idUsuario, nomeUsuario, idCronograma FROM usuario";
        if ($id > 0) {
            $sql .= " WHERE idUsuario = ?";
        } else {
            $sql .= " WHERE nomeUsuario = ?";
            $sql .= " AND senha = ?";
        }
        $stmt = $this->conn->prepare($sql);
        if ($id > 0) {
            $stmt->bindParam(1, $id);
        } else {
            $stmt->bindParam(1, $nome);
            $stmt->bindParam(2, $senha);
        }
        $stmt->execute();
        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rs as $obj) {
            $o = new Usuario();
            $o->setId($obj["idUsuario"]);
            $o->setNome($obj["nomeUsuario"]);
            $idC = $obj["idCronograma"];
            if ($idC === null) {//não possui cronograma
                $o->setIdCronograma(0);
                $o->setCargos([]);
            } else {//possui cronograma
                $o->setIdCronograma($idC);
                $sqlCg = 'SELECT cargo.idCargo, nomeCargo';
                $sqlCg .= ' FROM usuario_cargo JOIN cargo';
                $sqlCg .= ' ON usuario_cargo.idCargo=cargo.idCargo';
                $sqlCg .= ' WHERE usuario_cargo.idUsuario = ' . $o->getId();
                $stmtCg = $this->conn->prepare($sqlCg);
                $stmtCg->execute();
                $rsCg = $stmtCg->fetchAll(PDO::FETCH_ASSOC);
                foreach ($rsCg as $cg){//extrai os cargos do usuário
                    $cargo = new Cargo();
                    $cargo->setId($cg["idCargo"]);
                    $cargo->setNome($cg["nomeCargo"]);
                    $cargos[] = $cargo;
                }
                $o->setCargos($cargos);
            }
            $list[] = $o;
        }
        return $list;
    }

    public function salvar($objeto) {
        $o = new Usuario();
        $o = $objeto;
        $nome = $o->getNome();
        $senha = $o->getSenha();
        $sql = "INSERT INTO usuario VALUES (0, ?, ?, NULL)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $senha);
        $stmt->execute();
        return true;
    }

}
