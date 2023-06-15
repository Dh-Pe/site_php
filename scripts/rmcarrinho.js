function removerDoCarrinho(button) {
    const formData = new FormData();
    formData.append('id', button.id);

    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            window.location.href="carrinho.php";
        }
    };
    xhttp.open("POST", "php/rmcarrinho.php", true);
    xhttp.send(formData);
}