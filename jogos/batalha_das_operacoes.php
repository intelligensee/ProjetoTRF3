<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/disciplinas.css"/>
        <link rel="stylesheet" href="../css/jogos/batalha_das_operacoes.css"/>
    </head>
    <body>
        <?php $ops = ['+', '-', 'x', '/']; ?>
        <h1 class="titulo conteiner">Matemática</h1>
        <h2 class="subTitulo conteiner meio">Batalha das Operações</h2>
        <div class="jogos meio borda-inf" id="principal">
            <div id="exercitoUp">
                <h3 class="exercito-norte" id="pontosUp">0 pontos</h3>
                <table>
                    <td class="exercito exercito-norte">Exército do Norte</td>
                    <td class="ponteiro" id="tdControlUp"> <<< </td>
                </table>
                <form>
                    <table class="tb-numeros">
                        <tr id="LinhaExercitoUp">
                            <?php
                            for ($i = 0; $i < 12; $i++) {
                                echo '<td class="btn-numeros" id="tdUpNum' . ($i + 1) . '"><input type="button" value=' . ($i + 1) . ' disabled onclick="alvo(' . ($i + 1) . ')"></td>';
                            }
                            ?>
                        </tr>
                    </table>
                    <span id="spanVencedorUp"></span>
                </form>
            </div>
            <div id="ComandoUp">
                <form>
                    <table class="tb-oper">
                        <tr id="LinhaOperacoesUp">
                            <?php
                            foreach ($ops as $value) {
                                echo '<td><input class="btn-oper btn-oper-norte exercito" type="button" value=' . $value . ' disabled onclick="operacao(\'' . $value . '\')"></td>';
                            }
                            ?>
                        </tr>
                    </table>
                    <span id="spanErroUp"></span>
                </form>
            </div>
            <div class="operacoes" id="operacoes">
            <hr>
                <form>
                    <table>
                        <td><input class="btn-acao" id="btCarregarArmas" type="button" value="Carregar Armas" onclick="jogarDados()"></td>
                        <td><input class="dado" id="DadoEsquerdo" type="button" value="?" disabled onclick="dado('DadoEsquerdo')"></td>
                        <td><input class="oper-text" id="op" type="text" disabled></td>
                        <td><input class="dado" id="DadoDireito" type="button" value="?" disabled onclick="dado('DadoDireito')"></td>
                        <td><input class="btn-acao" id="btAtirar" type="button" value="Atirar" disabled onclick="atirar()"></td>
                        <td><input class="btn-acao" id="btDesistir" type="button" value="Desistir" disabled onclick="desistir()"></td>
                    </table>
                </form>
            <hr>
            </div>
            <div id="ComandoDown">
                <form>
                    <table class="tb-oper">
                        <tr id="LinhaOperacoesDown">
                            <?php
                            foreach ($ops as $value) {
                                echo '<td><input class="btn-oper btn-oper-sul exercito" type="button" value=' . $value . ' disabled onclick="operacao(\'' . $value . '\')"></td>';
                            }
                            ?>
                        </tr>
                    </table>
                    <span id="spanErroDown"></span>
                </form>
            </div>
            <div id="exercitoDown">
                <form>
                    <table class="tb-numeros">
                        <tr id="LinhaExercitoDown">
                            <?php
                            for ($i = 0; $i < 12; $i++) {
                                echo '<td class="btn-numeros" id="tdDownNum' . ($i + 1) . '"><input type="button" value=' . ($i + 1) . ' disabled onclick="alvo(' . ($i + 1) . ')"></td>';
                            }
                            ?>
                        </tr>
                    </table>
                    <span id="spanVencedorDown"></span>
                </form>
                <table>
                    <td class="exercito exercito-sul">Exército do Sul</td>
                    <td class="ponteiro" id="tdControlDown"></td>
                </table>
                <h3 class="exercito-sul" id="pontosDown">0 pontos</h3>
            </div>
        </div>


        <script>
            var controle = 'Up';
            var n1;
            var n2;
            var op = null;
            var resultado;
            var acertosUp = 0;
            var acertosDown = 0;
            var pontosUp = 0;
            var pontosDown = 0;
            var fator;
            function jogarDados() {
                document.getElementById("op").value = "";
                document.getElementById("btAtirar").disabled = true;
                document.getElementById("DadoEsquerdo").value = Math.floor(Math.random() * 6 + 1);
                document.getElementById("DadoDireito").value = Math.floor(Math.random() * 6 + 1);
                document.getElementById("DadoEsquerdo").disabled = false;
                document.getElementById("DadoDireito").disabled = false;
                document.getElementById("btCarregarArmas").disabled = true;
                document.getElementById("btDesistir").disabled = false;
                document.getElementById("spanErro" + controle).innerHTML = "";
                document.getElementById("spanVencedor" + controle).innerHTML = "";
                op = null;
            }

            function dado(valor) {
                var opr = document.getElementById(valor).value;
                if (document.getElementById("op").value === "") {
                    document.getElementById("op").value = opr;
                    botoesOperacao(false);
                    n1 = Number(opr);
                    document.getElementById(valor).disabled = true;
                } else if (op !== null) {
                    var operacao = document.getElementById("op").value;
                    document.getElementById("op").value = operacao + " " + opr;
                    botoesNumeros(false);
                    n2 = Number(opr);
                    document.getElementById(valor).disabled = true;
                }
            }

            function operacao(valor) {
                var operacao = document.getElementById("op").value;
                document.getElementById("op").value = operacao + " " + valor;
                botoesOperacao(true);
                op = valor;
            }

            function alvo(valor) {
                var operacao = document.getElementById("op").value;
                document.getElementById("op").value = operacao + " = " + valor;
                botoesNumeros(true);
                document.getElementById("btAtirar").disabled = false;
                resultado = valor;
            }

            function atirar() {
                var x;
                switch (op) {
                    case op = '+':
                        x = n1 + n2;
                        fator = 1;
                        break;
                    case op = '-':
                        x = n1 - n2;
                        fator = 2;
                        break;
                    case op = 'x':
                        x = n1 * n2;
                        fator = 3;
                        break;
                    case op = '/':
                        x = n1 / n2;
                        fator = 4;
                }
                if (x === Number(resultado)) {
                    var id = "td" + controle + "Num" + resultado;
                    document.getElementById(id).hidden = true;
                    if (controle === 'Up') {
                        acertosUp++;
                        pontosUp += fator;
                        document.getElementById("pontosUp").innerHTML = pontosUp + " pontos";
                    } else {
                        acertosDown++;
                        pontosDown += fator;
                        document.getElementById("pontosDown").innerHTML = pontosDown + " pontos";
                    }
                    if (acertosUp === 12 || acertosDown === 12) {
                        document.getElementById("spanVencedor" + controle).innerHTML = "Você venceu!";
                        document.getElementById("btAtirar").disabled = true;
                        document.getElementById("btDesistir").disabled = true;
                        return;
                    }
                } else {
                    document.getElementById("spanErro" + controle).innerHTML = "Errou!";
                }
                document.getElementById("btCarregarArmas").disabled = false;
                document.getElementById("btAtirar").disabled = true;
                document.getElementById("btDesistir").disabled = true;
                trocarControle();
            }

            function desistir() {
                document.getElementById("DadoDireito").disabled = true;
                document.getElementById("DadoEsquerdo").disabled = true;
                document.getElementById("btCarregarArmas").disabled = false;
                document.getElementById("btAtirar").disabled = true;
                document.getElementById("btDesistir").disabled = true;
                botoesOperacao(true);
                botoesNumeros(true);
                trocarControle();
            }

            function botoesOperacao(desabilitar) {
                var linha = document.getElementById("LinhaOperacoes" + controle);
                var bts = linha.getElementsByTagName('input');
                for (i = 0; i < bts.length; i++) {
                    bts[i].disabled = desabilitar;
                }
            }

            function botoesNumeros(desabilitar) {
                var linha = document.getElementById("LinhaExercito" + controle);
                var bts = linha.getElementsByTagName('input');
                for (i = 0; i < bts.length; i++) {
                    bts[i].disabled = desabilitar;
                }
            }

            function trocarControle() {
                document.getElementById("tdControl" + controle).innerHTML = "";
                if (controle === 'Up') {
                    controle = 'Down';
                } else {
                    controle = 'Up';
                }
                document.getElementById("tdControl" + controle).innerHTML = " <<<";
            }
        </script>
    </body>
</html>
