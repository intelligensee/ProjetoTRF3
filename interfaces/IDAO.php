<?php

interface IDAO {

    public function atualizar($objeto);

    public function excluir($objeto);

    public function pesquisar($objeto);

    public function salvar($objeto);
}
