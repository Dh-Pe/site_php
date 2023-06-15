<?php
include_once('conexao.php');

if (
    isset($_POST['cadastrar']) && // Verifica se o botão "Cadastrar" foi enviado
    isset($_POST['nome']) &&
    isset($_POST['email']) &&
    isset($_POST['senha']) &&
    isset($_POST['endereco'])
) {
    $nome = $mysqli->real_escape_string($_POST['nome']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $senha = $mysqli->real_escape_string($_POST['senha']);
    $endereco = $mysqli->real_escape_string($_POST['endereco']);

    $sql_code = "SELECT * FROM usuarios WHERE email = '$email'";

    $sql_query = $mysqli->query($sql_code) or die('Erro ao consultar' + $mysqli->error);

    if ($sql_query->num_rows == 0) {
        $sql_code2 = "INSERT INTO usuarios (nome, email, senha, endereco)
                        VALUES ('$nome', '$email', '$senha', '$endereco')";
        $sql_query2 = $mysqli->query($sql_code2) or die('Erro ao consultar' . $mysqli->error);
        $valor = 1;
        $type = 'cadastro'; // Correção: Definir o valor 'cadastro' para a variável $type
        header("location: ../login.php?type=" . urlencode($type) . "&valor=" . urlencode($valor));
    } else {
        $valor = 0;
        $type = 'cadastro'; // Correção: Definir o valor 'cadastro' para a variável $type
        header("location: ../login.php?type=" . urlencode($type) . "&valor=" . urlencode($valor));
    }
}
?>