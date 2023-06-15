<?php
include './conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $email = $_SESSION['email'];

    $sql_update = "UPDATE carrinhos SET quantidade = quantidade + 1 WHERE email_usuario = ? AND id_produto = ? AND comprado = false";
    $stmt_update = $mysqli->prepare($sql_update);
    $stmt_update->bind_param('si', $email, $id);
    $stmt_update->execute();

    if ($stmt_update->affected_rows === 0) {
        $sql_insert = "INSERT INTO carrinhos (id_produto, email_usuario, quantidade) VALUES (?, ?, 1)";
        $stmt_insert = $mysqli->prepare($sql_insert);
        $stmt_insert->bind_param('is', $id, $email);
        $stmt_insert->execute();

        if ($stmt_insert->affected_rows === -1) {
            die('Erro na inserção: ' . $stmt_insert->error);
        }
    }

    $stmt_update->close();
    $stmt_insert->close();
}

$mysqli->close();
?>
