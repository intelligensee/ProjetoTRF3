<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/disciplinas.css">
        <?php
        $idD = $_GET['d'];
        $idA = $_GET['a'];
        require_once '../controllers/Controller.php';
        require_once '../dominio/Disciplina.php';
        require_once '../dominio/Assunto.php';
        require_once '../dominio/Video.php';
        require_once '../dominio/Exercicio.php';
        require_once '../dominio/Jogo.php';
        $c = new Controller();
        $d = new Disciplina();
        $a = new Assunto();
        $v = new Video();
        $e = new Exercicio();
        $j = new Jogo();
        //Disciplina
        $d->setId($idD);
        $rd = $c->processar("PESQUISAR", $d);
        //Assunto
        $a->setId($idA);
        $ra = $c->processar("PESQUISAR", $a);
        //Vídeos
        $v->setIdAssunto($idA);
        $rv = $c->processar("PESQUISAR", $v);
        //Exercícios
        $e->setIdAssunto($idA);
        $re = $c->processar("PESQUISAR", $e);
        //Jogos
        $j->setIdAssunto($idA);
        $rj = $c->processar("PESQUISAR", $j);
        ?>
    </head>
    <body>
        <header>
            <h1 class="titulo conteiner"><?php echo $rd[1][0]->getNome() ?></h1>
            <h2 class="subTitulo conteiner meio"><?php echo $ra[1][0]->getNome() ?></h2>
        </header>
        <main>
            <section class="videos conteiner meio">
                <h3>Vídeo Aulas</h3>
                <ul>
                    <?php
                    foreach ($rv[1] as $vd) {
                        echo '<li><a href="' . $vd->getLink() . '">' . $vd->getNome() . '</a></li>';
                    }
                    ?>
                </ul>
            </section>
            <section class="exercicios conteiner meio">
                <h3>Exercícios</h3>
                <ul>
                    <?php
                    foreach ($re[1] as $exerc) {
                        echo '<li><a href="' . $exerc->getLink() . '">' . $exerc->getNome() . '</a></li>';
                    }
                    ?>
                </ul>
                <h4>*Resolva os exercícios de 1 a 23</h4>
            </section>
            <section class="jogos conteiner meio borda-inf">
                <h3>Jogos</h3>
                <ul>
                    <?php
                    foreach ($rj[1] as $jg) {
                        echo '<li><a href="jogos/' . $jg->getCaminho() . '">' . $jg->getNome() . '</a></li>';
                    }
                    ?>
                </ul>
            </section>
        </main>
    </body>
</html>
