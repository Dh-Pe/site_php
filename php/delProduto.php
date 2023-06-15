<?php
include_once("./conexao.php");

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql_query = $mysqli->query("DELETE FROM produtos WHERE id = $id");
        $sql_query2 = $mysqli->query("DELETE FROM carrinho WHERE produtoId = $id");

        header('location: ../painel.php');
    } else {
        header('location: ../painel.php');
    }
} else {
    header('location: ../painel.php');
}