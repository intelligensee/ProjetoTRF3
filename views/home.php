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
            <div class="cargos">
                <h3><u>Principais Informações:</u></h3>
                <p>
                    <br />
                <b>Cargo/Órgão:</b> Analista Judiciário e Técnico Judiciário para diversos cargos/áreas/especialidades/TRF 3ª Região (MS e SP)<br />
                <b>Remuneração inicial:</b> R$ 12.455,30 (Analista Judiciário) e R$ 7.591,37 (Técnico Judiciário)<br />
                <b>Escolaridade:</b> nível superior e nível médio<br />
                <b>Banca:</b> Fundação Carlos Chagas (FCC)<br />
                <b>Data da prova:</b> a definir<br />
                <b>Locais de prova:</b> a definir<br />
                <b>Último Edital: </b><a href="http://www.in.gov.br/en/web/dou/-/edital-n-1-de-5-de-setembro-de-2019concurso-publico-214886603?fbclid=IwAR1L81cLwL-VWOdjDx3sLeOcy2fK7FNmN-SEfIQk_MkxS0LgRldJLSvt1L4">TRF 3ª Região </a>
                </p>
                <br />
                <center>
                    <table>
                        <tr>
                            <?php
                                //lista dos cargos cadastrados no sistema
                                $i = 1;
                                $qtd = count($cargos[1]);
                                foreach ($cargos[1] as $cg) {
                                    echo '<td>';
                                    echo '<input type="checkbox" id="chk' . $i++ . '" onchange="carregarCargo(' . $qtd . ', true)">';
                                    echo '<label class="container">' . $cg->getNome() . '</label>';
                                    echo '</td>';
                                }                
                            ?>
                        </tr>
                    </table>
                    </center>
            </div>
            <br />
            <div class="disciplinas">
                <section id="homeQuantidade"></section>
                <section id="homeDisciplinas"></section>
            </div>
        </main>
        <?php include "rodape.php"; ?>
    </body>
</html>
