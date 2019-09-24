<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Concurso TRF 3ª Região</title>
        <script src="../ajax/home.js"></script>
        <script src="../ajax/login.js"></script>
        <script
            src = "https://code.jquery.com/jquery-3.4.0.js"
            integrity = "sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
            crossorigin = "anonymous">
        </script>
        <?php
        require_once '../views/menu.php';
        require_once '../controllers/Controller.php';
        require_once '../dominio/Disciplina.php';
        require_once '../dominio/Cargo.php';
        $c = new Controller();
        $disciplinas = $c->processar("PESQUISAR", new Disciplina());
        $cargos = $c->processar("PESQUISAR", new Cargo());
        ?>
    </head>
    <body onload="verificarLog(<?php echo count($cargos[1]) ?>)">
        <main class="principal">
            <center>
                <div>
                    <button id="btCronograma" class="button topButton" disabled onclick="window.location = '../views/cronograma.php'">Cronograma</button>
                    <button class="button topButton" onclick="window.location = '../views/estudar.php'">Estudar</button>
                </div>
                <div class="cargos">
                    <table>
                        <tr>
                            <?php
                            //lista dos cargos cadastrados no sistema
                            $i = 1;
                            $qtd = count($cargos[1]);
                            foreach ($cargos[1] as $cg) {
                                echo '<td class="tdCargos">';
                                echo '<input type="checkbox" id="chk' . $i++ . '" onchange="carregarCargo(' . $qtd . ', true)">';
                                echo '<label class="container">' . $cg->getNome() . '</label>';
                                echo '</td>';
                            }
                            ?>
                        </tr>
                    </table>
                </div>
                <br />
                <div class="disciplinas">
                    <section id="homeQuantidade"></section>
                    <section id="homeDisciplinas"></section>
                </div>

            </center>
        </main>
        <?php include "rodape.php"; ?>
    </body>
</html>
