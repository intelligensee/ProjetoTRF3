<?php

class SalvarCommand extends Command {
    
    public function executar($objeto) {
        $f = new Fachada();
        return $f->salvar($objeto);
    }

}
