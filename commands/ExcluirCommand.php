<?php

class ExcluirCommand extends Command {
    
    public function executar($objeto) {
        $f = new Fachada();
        return $f->excluir($objeto);
    }

}
