<?php

require_once (__ROOT__ . '/interfaces/IStrategy.php');

class VerificaSenha implements IStrategy {

    public function verificar($objeto) {
        $senha = $objeto->getSenha();
        if (empty(trim($senha))) {
            return 'ErroSenha01';
        }
        return null;
    }

}
