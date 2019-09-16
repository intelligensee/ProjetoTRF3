<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/disciplinas.css">
        <script src="../ajax/cronograma.js"></script>
    </head>
    <body onload="carregarCronograma()">
        <header>
            <h1 class="titulo conteiner">Cronograma</h1>
            <h2 class="conteiner meio" id="BoasVindas"></h2>
        </header>
        <main>
            <section class="conteiner meio" id="secCronoProg" hidden>
                <progress class="progresso" max="100" id="cronoProg"></progress>
            </section>
            <section class="datas conteiner meio" id="param" hidden>
                <form>
                    <label>Data de Início: </label>
                    <input type="date" id="dataIni" onchange="alterar()">
                    <label>Termina em: </label>
                    <span id="dataFim"></span></br>
                    
                    <label>Assuntos por Dia: </label>
                    <input type="text" id="txtQtd" value="1" onchange="alterar()"></br>

                    
                    <input type="checkbox" checked id="chkDom" onchange="alterar()">
                    <label>Domingo</label>
                    
                    <input type="checkbox" checked id="chkSeg" onchange="alterar()">
                    <label>Segunda</label>
                    
                    <input type="checkbox" checked id="chkTer" onchange="alterar()">
                    <label>Terça</label>
                    
                    <input type="checkbox" checked id="chkQua" onchange="alterar()">
                    <label>Quarta</label>
                    
                    <input type="checkbox" checked id="chkQui" onchange="alterar()">
                    <label>Quinta</label>
                    
                    <input type="checkbox" checked id="chkSex" onchange="alterar()">
                    <label>Sexta</label>
                    
                    <input type="checkbox" checked id="chkSab" onchange="alterar()">
                    <label>Sábado</label></br>
                    
                    <span id="spnCronoQtdAssuntos"></span>
                </form>
            </section>
            <section class="cronograma conteiner meio">
                <span id="tabela">Carregando cronograma... Aguarde!</span>
            </section>
        </main>
        <footer class="conteiner meio borda-inf">
            <button class="btCrono btCronoSalvar" id="btCronoSalvar" hidden onclick="executar('SALVAR')">Salvar</button>
            <button class="btCrono btCronoExcluir" id="btCronoExcluir" hidden onclick="executar('EXCLUIR')">Excluir</button>
        </footer>
    </body>
</html>
