<?php
include_once('./conexao.php');

if (isset($_POST['email']) && isset($_POST['novaSenha'])) {
    $email = $mysqli->real_escape_string($_POST['email']);
    $novaSenha = $mysqli->real_escape_string($_POST['novaSenha']);

    // Verifica se o usuário existe no banco de dados
    $sql_code = "SELECT * FROM usuarios WHERE email = '$email'";
    $sql_query = $mysqli->query($sql_code) or die('Erro ao consultar' + $mysqli->error);

    if ($sql_query->num_rows == 0) {
        $type = 'alteracao';
        $valor = 0;
        header("location: ../login.php?type=" . urlencode($type) . "&valor=" . urlencode($valor));
    } else {
        $update_code = "UPDATE usuarios SET senha = '$novaSenha' WHERE email = '$email'";
        $update_query = $mysqli->query($update_code) or die('Erro ao atualizar senha' + $mysqli->error);

        $type = 'alteracao';
        $valor = 1;
        header("location: ../login.php?type=" . urlencode($cadastro) . "&valor=" . urlencode($valor));
    }
}