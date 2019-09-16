function verificarLog(qtd) {
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
                    document.getElementById("chk" + i).checked = valor;
                    document.getElementById("chk" + i++).disabled = true;
                });
            } else {//não logado
                document.getElementById("login").hidden = false;
                document.getElementById("logado").hidden = true;
            }
            carregarCargo(qtd, false);
        }
    };

    xmlhttp.open("GET", "../ajax/verificaLog.php", true);
    xmlhttp.send();
}

function carregarCargo(qtd, alteracao) {
    var xmlhttp = new XMLHttpRequest();
    var dados = [alteracao];

    for (var i = 0; i < qtd; i++) {
        dados.push(document.getElementById("chk" + (i + 1)).checked);
    }

    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var resp = this.responseText.split("§");
            document.getElementById("homeDisciplinas").innerHTML = resp[0];
            document.getElementById("homeQuantidade").innerHTML = resp[1];
        }
    };

    xmlhttp.open("GET", "../ajax/carregaCargo.php?q=" + dados, true);
    xmlhttp.send();
}