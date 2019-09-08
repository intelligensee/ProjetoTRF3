<?php

require_once (__ROOT__ . '/interfaces/IDAO.php');
require_once (__ROOT__ . '/util/ConnectionFactory.php');
require_once (__ROOT__ . '/dominio/Video.php');

class VideoDAO implements IDAO {

    private $conn;

    function __construct() {
        $this->conn = ConnectionFactory::getMySQLConnection();
    }

    public function atualizar($objeto) {
        
    }

    public function excluir($objeto) {
        
    }

    public function pesquisar($objeto) {
        $idA = $objeto->getIdAssunto();
        $sql = "SELECT idVideo, nomeVideo, link FROM video";
        $sql .= " WHERE idAssunto = " . $idA;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($rs)) {
            return;
        } else {
            foreach ($rs as $obj) {
                $o = new Video();
                $o->setId($obj["idVideo"]);
                $o->setNome($obj["nomeVideo"]);
                $o->setLink($obj["link"]);
                $list[] = $o;
            }
            return $list;
        }
    }

    public function salvar($objeto) {
        
    }

}
