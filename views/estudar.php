<html>
    <head>
        <meta charset="UTF-8">
        <script src="../ajax/tarefa.js"></script>
        <?php
            require_once '../views/menu.php';
        ?>
    </head>
    <body onload="carregarTarefa()">
        <header>
            <h1 class="conteiner titulo tituloEstudar">Estudar</h1>
            <h2 id="estudarDisciplina" class="tituloDisciplina meio conteiner"></h2>
        </header>
        <main>
            <section class="conteiner meio">
                <progress class="progresso" max="100" id="estudarProg"></progress>
            </section>
            <h1 id="estudarAssunto" class="subTitulo conteiner meio"></h1>
            <section class="conteiner meio borda-inf">
                <button id="btEstudado" class="btEstudado" hidden 
                        onclick="atualizarStatus()">Estudado
                </button>
            </section>
        </main>
        <?php include "rodape.php"; ?>
    </body>
</html>
