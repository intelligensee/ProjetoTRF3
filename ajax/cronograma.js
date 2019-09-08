function carregarCronograma() {//Carregar cronograma na abertura da página
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var resp = this.responseText.split("?");
            document.getElementById('BoasVindas').innerHTML = resp[0];
            document.getElementById('dataIni').value = resp[1];
            document.getElementById('tabela').innerHTML = resp[2];
            document.getElementById('dataFim').innerHTML = resp[3];
            document.getElementById('param').hidden = resp[4];
            document.getElementById('secCronoProg').hidden = !resp[4];
            document.getElementById('btCronoSalvar').hidden = resp[4];
            document.getElementById('btCronoExcluir').hidden = !resp[4];
            document.getElementById('cronoProg').value = resp[5];
            document.getElementById('cronoProg').title = resp[5] + '%';
        }
    };

    xmlhttp.open("GET", "../ajax/cronograma.php?q=load", true);
    xmlhttp.send();
}

function alterar() {//alterar parâmetros do cronograma
    var xmlhttp = new XMLHttpRequest();
    var dados = null;

    var elementos = [//ids das checkboxs
        'chkDom',
        'chkSeg',
        'chkTer',
        'chkQua',
        'chkQui',
        'chkSex',
        'chkSab'
    ];
    
    dados = document.getElementById('dataIni').value;//data de início
    dados += '§' + document.getElementById('txtQtd').value;//quantidade p/ dia
    
    //recupera os valores das checkboxs e adiciona ao valor da quantidade
    elementos.forEach(function (valor) {
        dados += '§' + document.getElementById(valor).checked;
    });

    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            var resp = this.responseText.split("?");
            document.getElementById('tabela').innerHTML = resp[0];
            document.getElementById('dataFim').innerHTML = resp[1];
        }
    };

    xmlhttp.open("GET", "../ajax/cronograma.php?q=alt?" + dados, true);
    xmlhttp.send();
}

function executar(operacao) {//Salvar ou Excluir
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText) {
                window.location = "../views/cronograma.php";
            } else {
                window.location = "../views/login.php";
            }
        }
    };

    xmlhttp.open("GET", "../ajax/cronograma.php?q=opr?" + operacao, true);
    xmlhttp.send();
}
