<?php

require_once (__ROOT__ . '/interfaces/IStrategy.php');

class VerificaNome implements IStrategy {

    public function verificar($objeto) {
        $nome = $objeto->getNome();
        if (empty(trim($nome))) {
            return 'ErroNome01';
        }
        return null;
    }

}
