document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Impede o envio tradicional do formulário

        // Capturando os valores dos campos do formulário
        const formData = new FormData(form); // Cria um objeto FormData com os dados do formulário

        // Enviando os dados para o PHP via fetch
        fetch("cadastro.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text()) // Processa a resposta do PHP como texto
        .then(data => {
            console.log("Resposta do PHP:", data); // Exibe a resposta do PHP no console
            alert("Formulário enviado com sucesso!"); // Mensagem de sucesso
            form.reset(); // Limpa o formulário
        })
        .catch(error => {
            console.error("Erro ao enviar o formulário:", error); // Exibe erros no console
            alert("Ocorreu um erro ao enviar o formulário.");
        });
    });
});
