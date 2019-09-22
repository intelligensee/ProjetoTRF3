<html>
    <head>
        <meta charset="UTF-8">
        <?php
        $id = $_GET['id'];
        $ops = $_GET['ops'];
        require_once '../views/menu.php';
        require_once '../controllers/Controller.php';
        require_once '../dominio/Disciplina.php';
        require_once '../dominio/Assunto.php';
        $c = new Controller();
        $d = new Disciplina();
        $a = new Assunto();
        //Disciplina
        $d->setId($id);
        $rd = $c->processar("PESQUISAR", $d);
        //Cargos escolhidos
        $cg = explode('%', $ops);
        $rc = $c->processar("PESQUISAR", new Cargo());
        $lista = $rc[1];
        for ($i = 0; $i < count($lista); $i++) {//cada cargo cadastrado
            if ($cg[$i] === 't') { //se foi escolhido este cargo
                $cargos[] = $lista[$i];
                $conteudo = true;
            }
        }
        if ($conteudo) {
            $a->setCargos($cargos);
        }

        //Assuntos da Disciplina de acordo com os cargos escolhidos
        $a->setIdDisciplina($id);
        $ra = $c->processar("PESQUISAR", $a);
        ?>
    </head>
    <body>
        <h1 class="titulo conteiner"><?php echo $rd[1][0]->getNome() ?></h1>
        <h2 class="subTitulo conteiner meio"><?php echo count($ra[1]) . ' Assuntos' ?></h2>
        <nav idAssuntos class="assuntos conteiner meio">
            <ul>
                <?php
                foreach ($ra[1] as $ass) {
                    echo '<li>' . $ass->getNome() . '</li>';
                }
                ?>
            </ul>
        </nav>
        <?php include "rodape.php"; ?>
    </body>
</html>
