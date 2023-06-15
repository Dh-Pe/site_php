<?php
session_start();

if (isset($_SESSION['nome'])) {
    $nome = $_SESSION['nome'];
    $email = $_SESSION['email'];
} else {
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
    <link rel="stylesheet" href="style/painel.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/f2cd3193ae.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="assets/CC-SHIRT_logo.png" alt="Logo" height="55">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link icone" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link icone" href="contato.php">Contato</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link icone" href="sobrenos.php">Sobre</a>
                    </li>
                    <li id="perfil" class="nav-item dropdown">
                        <a id="drop" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-user"></i>
                            <?php
                            if (isset($email) && isset($nome)) {
                                include_once('php/conexao.php');
                                $sql_code = "SELECT * FROM carrinhos WHERE email_usuario = '$email' AND comprado = false";
                                $sql_query = $mysqli->query($sql_code) or die("Erro ao consultar o banco de dados: " . $mysqli->error);
                                $count = 0;

                                if ($sql_query->num_rows > 0) {
                                    while ($dados = $sql_query->fetch_assoc()) {
                                        $count = $count + $dados['quantidade'];
                                    }

                                    if ($count > 0) {
                                        echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">';
                                        echo $count;
                                        echo '<span class="visually-hidden">unread messages</span>';
                                        echo '</span>';
                                    }
                                }
                            }
                            ?>
                        </a>
                        <ul class="dropdown-menu">
                            <?php
                            if (isset($email) && isset($nome)) {
                                $nome = explode(' ', $nome);
                                echo '<li><a class="dropdown-item disabled">Olá, ' . $nome[0] . '</a></li>';
                                echo '<li><hr class="dropdown-divider"></li>';
                                if ($nome[0] == "administrador" && $email == "administrador@admin.com") {
                                    echo '<li><a class="dropdown-item" href="painel.php">Painel</a></li>';
                                } else {

                                    echo '<li><a class="dropdown-item" href="carrinho.php">Carrinho</a></li>';
                                    echo '<li><a class="dropdown-item" href="compras.php">Compras</a></li>';
                                }
                                echo '<li><hr class="dropdown-divider"></li>';
                                echo '<li><a class="dropdown-item" href="php/logoff.php">Sair</a></li>';
                            } else {
                                echo '<li><a class="dropdown-item" href="login.php">Login</a></li>';
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <h1 class="title">Painel de Controle</h1>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Preço</th>
                <th scope="col">Unidades</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>

            <?php
            include_once("php/conexao.php");

            $sql_query = $mysqli->query("SELECT * FROM produtos ORDER BY id") or die("Erro ao consultar o banco" . $mysqli->error);

            if ($sql_query->num_rows > 0) {
                while ($dados = $sql_query->fetch_assoc()) {
                    echo "<tr>";
                    echo "<th scope='row'>" . $dados['id'] . "</th>";
                    echo "<td>" . $dados['nome'] . "</td>";
                    echo "<td>" . $dados['preco'] . "</td>";
                    echo "<td>" . $dados['estoque'] . "</td>";
                    echo "<td>";
                    echo "<a href='php/delProduto.php?id=" . $dados['id'] . "'><button type='button' class='btn btn-danger'>Excluir</button></a>";
                    echo "<a href='php/editarproduto.php?id=" . $dados['id'] . "'><button type='button' class='btn btn-primary'>Editar</button></a>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</body>

</html>