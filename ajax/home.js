function verificarLog() {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var resp = this.responseText.split("?");
            if (resp[0]) {//logado
                document.getElementById("login").hidden = true;
                document.getElementById("logado").hidden = false;
                var cgs = resp[1].split("§");
                var i = 1;
                cgs.forEach(function (valor) {
                    document.getElementById("chk" + i++).checked = valor;
                });
            } else {//não logado
                document.getElementById("login").hidden = false;
                document.getElementById("logado").hidden = true;
            }
        }
    };

    xmlhttp.open("GET", "../ajax/verificaLog.php", true);
    xmlhttp.send();
}

function alterarCargo(qtd) {
    var xmlhttp = new XMLHttpRequest();
    var dados = [];

    for (var i = 0; i < qtd; i++) {
        dados.push(document.getElementById("chk" + (i+1)).checked);
    }


    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            alert('AJAX: ' + this.responseText);
        }
    };

    xmlhttp.open("GET", "../ajax/alteraCargo.php?q=" + dados, true);
    xmlhttp.send();
}