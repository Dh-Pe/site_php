<?php
include './conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    $id = $_POST['id'];
    $email = $_SESSION['email'];

    $sql_code = "SELECT * FROM carrinhos WHERE email_usuario = '$email' AND id_produto = $id AND comprado = false";
    $sql_query = $mysqli->query($sql_code) or die('Erro ao consultar' . $mysqli->error);

    if ($sql_query->num_rows > 0) {
        $sql_code = "UPDATE carrinhos SET quantidade = quantidade - 1 WHERE email_usuario = '$email' AND id_produto = $id AND comprado = false";
        $sql_query = $mysqli->query($sql_code) or die('Erro ao alterar' . $mysqli->error);
    }
}