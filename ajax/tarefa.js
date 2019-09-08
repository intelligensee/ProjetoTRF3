function carregarTarefa() {
    var xmlhttp = new XMLHttpRequest();


    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText === "NÃO LOGADO") {
                window.location = "../views/login.php";
            } else if (this.responseText === "SEM CRONOGRAMA") {
                window.location = "../views/cronograma.php";
            } else {
                var resp = this.responseText.split("§");
                document.getElementById("estudarDisciplina").innerHTML = resp[0];
                document.getElementById("estudarAssunto").innerHTML = resp[1];
                document.getElementById("estudarProg").value = resp[5];
                document.getElementById("estudarProg").title = resp[5] + '%';
                document.getElementById("btEstudado").hidden = false;
            }
        }
    };

    xmlhttp.open("GET", "../ajax/tarefa.php?q=", true);
    xmlhttp.send();
}

function atualizarStatus() {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText === "NÃO LOGADO") {
                window.location = "../views/login.php";
            } else {
                window.location = "../views/cronograma.php";
            }
        }
    };

    xmlhttp.open("GET", "../ajax/tarefa.php?q=A", true);
    xmlhttp.send();
}