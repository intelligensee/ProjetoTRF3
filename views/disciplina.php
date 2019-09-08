<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/disciplinas.css">
        <?php
        $id = $_GET['id'];
        require_once '../controllers/Controller.php';
        require_once '../dominio/Disciplina.php';
        require_once '../dominio/Assunto.php';
        $c = new Controller();
        $d = new Disciplina();
        $a = new Assunto();
        //Disciplina
        $d->setId($id);
        $rd = $c->processar("PESQUISAR", $d);
        //Assuntos da Disciplina
        $a->setIdDisciplina($id);
        $ra = $c->processar("PESQUISAR", $a);
        ?>
    </head>
    <body>
        <h1 class="titulo conteiner"><?php echo $rd[1][0]->getNome() ?></h1>
        <h2 class="subTitulo conteiner meio">Assuntos</h2>
        <nav idAssuntos class="assuntos conteiner meio">
            <ul>
                <?php
                foreach ($ra[1] as $ass) {
                    echo '<li>' . $ass->getNome() . '</li>';
                }
                ?>
            </ul>
        </nav>
    </body>
</html>
