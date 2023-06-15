<?php
include_once('conexao.php');
session_start();

if (isset($_SESSION['nome'])) {
    $email = $_SESSION['email'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $comentario = $_POST['comentario'];

        $sql_code = "INSERT INTO comentarios (email_usuario, comentario) VALUES ('$email', '$comentario')";
        $sql_query = $mysqli->query($sql_code) or die('Erro ao inserir na tabela: ' . $mysqli->error);

        header('location: ../comentarios.php');
    }
} else {
    header('location: ../login.php');
}