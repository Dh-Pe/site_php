<?php
session_start();

if (isset($_SESSION['nome'])) {
    $email = $_SESSION['email'];
    $nome = $_SESSION['nome'];
} else {
    header('location: login.php');
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CC-Shirt</title>
    <!-- Referência ao CSS do Bootstrap 5.3.0 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Referência ao JavaScript do Bootstrap 5.3.0 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/f2cd3193ae.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/compras.css">
    <!-- Importe o Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Função pagamento -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

    <!-------------------------- TÍTULO ---------------------------->

    <h1 class="title">
        <i class="fa-solid fa-wallet"></i> <span>Compras</span>
    </h1>
    <?php
    $sql_query = $mysqli->query(
        "SELECT p.nome, p.imageURL, p.descricao, p.preco, c.quantidade, p.id
    FROM carrinhos c
    JOIN produtos p
    ON c.id_produto = p.id
    WHERE c.email_usuario = '$email'
    AND c.comprado = true
    AND c.quantidade > 0;"
    ) or die('Erro ao consultar' + $mysqli->error);

    if ($sql_query->num_rows == 0) {
        echo '<div class="text-center"><h3>Você não possui compras no momento</h3></div>';
    } else {
        echo '<div class="row">';
        while ($dados = $sql_query->fetch_assoc()) {
            echo '<div class="col-md-3 mb-4">';
            echo '<div class="card">';
            echo '<img src="' . $dados['imageURL'] . '" class="card-img-top" alt="' . $dados['nome'] . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $dados['nome'] . '</h5>';
            echo '<h6>' . number_format($dados['preco'], 2, ',', '.') . ' R$</h6>';
            echo '<p class="card-text">Quantidade: ' . $dados['quantidade'] . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    }
    ?>
</body>