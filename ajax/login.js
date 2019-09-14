function logar(log) {
    var xmlhttp = new XMLHttpRequest();
    var q = "";//padrão para sair

    if (log) {//entrar
        q = document.getElementById("logUser").value;
        q += "?" + document.getElementById("logSenha").value;
    }

    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText === "E") {//erro de login
                document.getElementById("logMsg").innerHTML = "Usuário e/ou senha inválidos!";
            } else {//saiu ou entrou
                window.location = "../views/home.php";
            }
        }
    };

    xmlhttp.open("GET", "../ajax/login.php?q=" + q, true);
    xmlhttp.send();
}