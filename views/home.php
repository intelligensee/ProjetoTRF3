<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Concurso TRF 3ª Região</title>
        <link rel="stylesheet" href="../css/index.css">
        <script src="../ajax/login.js"></script>
        <script
            src = "https://code.jquery.com/jquery-3.4.0.js"
            integrity = "sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
            crossorigin = "anonymous">
        </script>
        <?php
        require_once '../controllers/Controller.php';
        require_once '../dominio/Disciplina.php';
        require_once '../dominio/Cargo.php';
        $c = new Controller();
        $disciplinas = $c->processar("PESQUISAR", new Disciplina());
        $cargos = $c->processar("PESQUISAR", new Cargo());
        ?>
    </head>
    <body onload="verificarLog()">
        <header class="cabecalho">
            <a href="home.php" class="logo"></a>
            <h1 class="titulo">Concurso TRF 3ª Região</h1>
            <a href="#" class="btn-menu"></a>
            <nav class="menu">
                <a class="btn-close">x</a>
                <ul>
                    <li><a href="login.php">Entrar</a></li>
                    <li><a href="cronograma.php">Cronograma</a></li>
                    <li><a href="estudar.php">Estudar</a></li>
                    <li><a href="../teste/testes.php">Testes</a></li>
                    <li><a onclick="logar(false)">Sair</a></li>
                </ul>
            </nav>
            <a id="login" href="login.php" class="btn-login"></a>
            <span id="logado" hidden></span>
        </header>
        <main class="principal">
            <div class="estudo">
                <button class="btn-cronograma" onclick="window.location = 'cronograma.php'">Cronograma</button>
                <button class="btn-estudo" onclick="window.location = 'estudar.php'">Estudar</button>
            </div>
            <div class="cargos">
                <?php
                $i = 1;
                foreach ($cargos[1] as $cg) {
                    echo '<input type="checkbox" checked id="chk' . $i++ . '">';
                    echo '<label>' . $cg->getNome() . '</label>';
                }
                ?>
            </div>
            <div class="disciplinas">
                <?php
                foreach ($disciplinas[1] as $d) {
                    $id = $d->getId();
                    $nome = $d->getNome();
                    echo '<form method="post" action="disciplina.php?id=' . $id . '">';
                    echo '<input type="submit" value="' . $nome . '">';
                    echo '</form>';
                }
                ?>
            </div>
        </main>
        <script>
            $(".btn-menu").click(function () {
                $(".menu").show();
            });
            $(".btn-close").click(function () {
                $(".menu").hide();
            });
        </script>
    </body>
</html>
