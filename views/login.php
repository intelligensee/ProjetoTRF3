<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/disciplinas.css">
        <link rel="stylesheet" href="../css/login.css">
        <script src="../ajax/login.js"></script>
    </head>
    <body>
        <header>
            <h1 class="titulo conteiner">Login</h1>
        </header>
        <main>
            <form>
                <section class="conteiner meio">
                    <table>
                        <tr>
                            <td><label>Usuário: </label></td>
                        </tr>
                        <tr>
                            <td><input type="text" id="logUser"></td>
                        </tr>
                        <tr>
                            <td><label>Senha: </label></td>
                        </tr>
                        <tr>
                            <td><input type="password" id="logSenha"></td>
                        </tr>
                    </table>
                </section>
                <section class="conteiner meio">
                    <input type="button" id="logBtEntrar" value="Entrar" onclick="logar(true)">
                </section>
            </form>
        </main>
        <footer class="conteiner meio borda-inf">
            <h2 id="logMsg"></h2>
        </footer>
    </body>
</html>
