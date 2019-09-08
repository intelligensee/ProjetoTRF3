<?php

class PesquisarCommand extends Command {
    
    public function executar($objeto) {
        $f = new Fachada();
        return $f->pesquisar($objeto);
    }

}
