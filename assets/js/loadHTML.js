// Função para carregar o conteúdo HTML de um arquivo e inseri-lo no elemento especificado
function loadHTML(url, elementId) {
    fetch(url)
        .then(response => response.text())
        .then(data => {
            document.getElementById(elementId).innerHTML = data;
        })
        .catch(error => console.error('Erro ao carregar o HTML:', error));
}