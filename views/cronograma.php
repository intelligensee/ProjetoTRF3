<html>
    <head>
        <meta charset="UTF-8">
        <script src="../ajax/cronograma.js"></script>
        <link 
        <?php
            require_once '../views/menu.php';
        ?>        
    </head>
    <body onload="carregarCronograma()">
        <header class="principal">
            <h1 class="titulo conteiner">Cronograma</h1>
            <h2 class="conteiner meio" id="BoasVindas"></h2>
        </header>
        <main class="principal">
            <section class="conteiner meio" id="secCronoProg" hidden>
                <progress class="progresso" max="100" id="cronoProg"></progress>
            </section>
            <section class="datas conteiner meio" id="param" hidden>
                <form>
                    <div>
                    <table>
                        <tr>
                            <td>
                                <label>Data de Início: </label>
                            </td>
                            <td>
                                <input type="date" id="dataIni" onchange="alterar()">
                            </td>
                            <td>
                                <label>Termina em: </label>
                            </td>
                            <td>
                                <input type="text" id="dataFim" disabled></br>
                            </td>
                            <td>
                                <label>Assuntos por Dia: </label>
                            </td>
                            <td>
                                <input type="text" id="txtQtd" value="1" onchange="alterar()"></br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="checkbox" checked id="chkDom" onchange="alterar()">
                                <label>Domingo</label>
                            </td>
                            <td>
                                <input type="checkbox" checked id="chkSeg" onchange="alterar()">
                                <label>Segunda</label>
                            </td>
                            <td>
                                <input type="checkbox" checked id="chkTer" onchange="alterar()">
                                <label>Terça</label>
                            </td>
                            <td>
                                <input type="checkbox" checked id="chkQua" onchange="alterar()">
                                <label>Quarta</label>
                            </td>
                            <td>
                                <input type="checkbox" checked id="chkQui" onchange="alterar()">
                                <label>Quinta</label>
                            </td>
                            <td>
                                <input type="checkbox" checked id="chkSex" onchange="alterar()">
                                <label>Sexta</label>
                            </td>
                            <td>
                                <input type="checkbox" checked id="chkSab" onchange="alterar()">
                                <label>Sábado</label></br>
                            </td>
                        </tr>
                    </table>                    
                    <br />
                        <center>
                            <h3><span id="spnCronoQtdAssuntos"></span></h3>
                        </center>
                    <br />
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
        </div>
        <?php //include "rodape.php"; ?>
    </body>
</html>
