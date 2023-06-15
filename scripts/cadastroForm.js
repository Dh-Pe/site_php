
function validarFormulario() {
    var nomeInput = document.getElementById("nomeInput");
    var emailInput = document.getElementById("emailInput");
    var senhaInput = document.getElementById("senhaInput");
    var enderecoInput = document.getElementById("enderecoInput");

    // Remove a marcação de inválido dos campos
    nomeInput.classList.remove("is-invalid");
    emailInput.classList.remove("is-invalid");
    senhaInput.classList.remove("is-invalid");
    enderecoInput.classList.remove("is-invalid");

    // Verifica se os campos estão preenchidos corretamente
    var isValid = true;

    if (!nomeInput.checkValidity()) {
        nomeInput.classList.add("is-invalid");
        isValid = false;
    }

    if (!emailInput.checkValidity()) {
        emailInput.classList.add("is-invalid");
        isValid = false;
    }

    if (!senhaInput.checkValidity()) {
        senhaInput.classList.add("is-invalid");
        isValid = false;
    }

    if (!enderecoInput.checkValidity()) {
        enderecoInput.classList.add("is-invalid");
        isValid = false;
    }

    return isValid;
}