<?php

define('__ROOT__', dirname(dirname(__FILE__)));
require_once (__ROOT__ . '/commands/Command.php');
require_once (__ROOT__ . '/commands/AtualizarCommand.php');
require_once (__ROOT__ . '/commands/ExcluirCommand.php');
require_once (__ROOT__ . '/commands/PesquisarCommand.php');
require_once (__ROOT__ . '/commands/SalvarCommand.php');

class Controller {

    public function processar($comando, $objeto) {
        //Criação do mapa de comandos
        $mapa['ATUALIZAR'] = new AtualizarCommand();
        $mapa['EXCLUIR'] = new ExcluirCommand();
        $mapa['PESQUISAR'] = new PesquisarCommand();
        $mapa['SALVAR'] = new SalvarCommand();

        //Execução do comando
        $c = $mapa[$comando];
        $r = $c->executar($objeto);

        return $r;
    }

}
