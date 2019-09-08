<?php

class AtualizarCommand extends Command {

    public function executar($objeto) {
        $f = new Fachada();
        return $f->atualizar($objeto);
    }

}
