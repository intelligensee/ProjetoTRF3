function executarTeste(pagina) {
    var xmlhttp = new XMLHttpRequest();

    alert('Página de Testes 1');

    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById('Span').innerHTML = this.responseText;
        }
    };

    xmlhttp.open("GET", "../ajax/teste.php?q=" + pagina, true);
    xmlhttp.send();
}