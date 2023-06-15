<?php
session_start();

if (isset($_SESSION['nome'])) {
    $nome = $_SESSION['nome'];
    $email = $_SESSION['email'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CC-Shirt</title>
    <link href="style/contato.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/f2cd3193ae.js" crossorigin="anonymous"></script>
</head>


<!-------------------------- NAVBAR ---------------------------->

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
                        <a class="nav-link active icone" href="contato.php">Contato</a>
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

    <!------------------------------- TÍTULO --------------------------------->

    <h1 class="title">
        <i class="fa-solid fa-comments"></i> <span>Feedback</span>
    </h1>

    <!-------------------------- FORM ATENDIMENTO ---------------------------->
    <form action="php/registrar_comentario.php" method="post">
        <div class="form-floating">
            <textarea class="form-control" name="comentario" placeholder="Digite seu comentário" id="floatingTextarea"
                required></textarea>
            <label for="floatingTextarea">Digite aqui seu comentário</label>
        </div>
        <br />
        <input type="submit" value="Enviar">
    </form>
    <hr>
    <div class="cards">
        <?php
        include_once('php/conexao.php');
        $sql_code =
            "SELECT u.nome, c.data, c.comentario
                        FROM comentarios c
                            JOIN usuarios u
                                ON c.email_usuario = u.email
                                    ORDER BY data DESC;";
        $sql_query = $mysqli->query($sql_code) or die('Erro na consulta: ' . $mysqli->error);

        if ($sql_query->num_rows > 0) {
            while ($row = $sql_query->fetch_assoc()) {
                $timestamp = strtotime($row['data']);
                $dataFormatada = date('d/m/Y - H:i', $timestamp);

                echo '<div class="card" style="width: 18rem;">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title"><strong><u>' . $row['nome'] . '</u></strong></h5>';
                echo '</hr>';
                echo '<h6 class="card-subtitle mb-2 text-body-secondary">' . $dataFormatada . '</h6>';
                echo '<p class="card-text">' . $row['comentario'] . '</p>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "Nenhum comentário encontrado.";
        }
        ?>
    </div>
</body>

</html>