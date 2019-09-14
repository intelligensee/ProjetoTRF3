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
            document.getElementById('txtQtd').value = resp[6];
            document.getElementById('chkDom').checked = resp[7];
            document.getElementById('chkSeg').checked = resp[8];
            document.getElementById('chkTer').checked = resp[9];
            document.getElementById('chkQua').checked = resp[10];
            document.getElementById('chkQui').checked = resp[11];
            document.getElementById('chkSex').checked = resp[12];
            document.getElementById('chkSab').checked = resp[13];
        }
    };

    xmlhttp.open("GET", "../ajax/cronograma.php?q=load", true);
    xmlhttp.send();
}

function alterar() {//alterar parâmetros do cronograma
    var xmlhttp = new XMLHttpRequest();
    var dados = null;
    var controle = 0;

    var elementos = [//ids das checkboxs
        'chkDom',
        'chkSeg',
        'chkTer',
        'chkQua',
        'chkQui',
        'chkSex',
        'chkSab'
    ];
    
    var qtd = document.getElementById('txtQtd').value;//quantidade p/ dia
    if (isNaN(qtd) || qtd < 1 || qtd > 10) {//inválido
        //reajusta para 1
        qtd = 1;
        document.getElementById('txtQtd').value = qtd;
    }

    dados = document.getElementById('dataIni').value;//data de início
    dados += '§' + qtd;

    //recupera os valores das checkboxs e adiciona ao valor da quantidade
    elementos.forEach(function (valor) {
        dados += '§' + document.getElementById(valor).checked;
        if (document.getElementById(valor).checked) {//se escolheu esse dia
            controle++;//controle deixa de ser zero
        }
    });

    if (controle === 0) {//não escolheu nenhum
        document.getElementById('dataFim').innerHTML = '';
        document.getElementById('tabela').innerHTML = 'Escolha pelo menos um dia da semana!';
        document.getElementById('btCronoSalvar').hidden = true;
        return;
    }
    document.getElementById('btCronoSalvar').hidden = false;


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
