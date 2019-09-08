<?php

require_once (__ROOT__ . '/interfaces/IDAO.php');
require_once (__ROOT__ . '/util/ConnectionFactory.php');
require_once (__ROOT__ . '/dominio/Usuario.php');
require_once (__ROOT__ . '/dominio/Tarefa.php');

class TarefaDAO implements IDAO {

    private $conn;
    private $usuario;

    function __construct() {
        $this->conn = ConnectionFactory::getMySQLConnection();
        if (isset($_SESSION['usuario'])) {
            $this->usuario = unserialize($_SESSION['usuario']);
        }
    }

    public function atualizar($objeto) {
        $id = $objeto->getId();
        $sql = 'UPDATE tarefa SET status = 1 WHERE idTarefa = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return true;
    }

    public function excluir($objeto) {
        
    }

    public function pesquisar($objeto) {
        
    }

    public function salvar($objeto) {
        
    }

}
