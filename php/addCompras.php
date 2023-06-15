<?php
include_once('./conexao.php');

session_start();

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $sql_query1 = $mysqli->query(
        "SELECT c.id
        FROM carrinhos c
            JOIN produtos p
                ON c.id_produto = p.id
                WHERE c.email_usuario = '$email'
                    AND c.comprado = false
                    AND c.quantidade > 0;"
    ) or die('Erro na consulta: ' . $mysqli->error);
    while ($carrinhoNaoComprado = $sql_query1->fetch_assoc()) {

        $sql_query2 = $mysqli->query(
            "SELECT p.preco, c.quantidade
            FROM carrinhos c
                JOIN produtos p
                    ON c.id_produto = p.id
                    WHERE c.email_usuario = '$email'
                        AND c.comprado = false
                        AND c.quantidade > 0;"
        );

        
        $somatotal = 0;
        while ($valores = $sql_query2->fetch_assoc()) {
            $somatotal = $somatotal + ($valores['preco'] * $valores['quantidade']);
        }

        $id = $carrinhoNaoComprado['id'];
        $sql_query3 = $mysqli->query(
            "UPDATE carrinhos SET comprado = true WHERE id = $id"
        ) or die('Erro no update: ' . $mysqli->error);

        $sql_query4 = $mysqli->query(
            "INSERT INTO compras (email_usuario, total) VALUES ('$email', $somatotal)"
        ) or die('Erro no insert: ' . $mysqli->error);
    }

    header('location: ../compras.php');
} else {
    header('location: ../index.php');
}