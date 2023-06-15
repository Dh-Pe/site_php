<?php
session_start();

if (isset($_SESSION['nome'])) {
    $nome = $_SESSION['nome'];
    $email = $_SESSION['email'];
}
?>

<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CC-Shirt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/f2cd3193ae.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="style/sobrenos.css" />

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
                        <a class="nav-link icone" href="comentarios.php">Comentários</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active icone" href="sobrenos.php">Sobre</a>
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

    <h1 class="title">A paixão por Camisas de Times</h1>

    <!-------------------------- PARÁGRAFOS ------------------------>
    <div class="conteudo">
        <div class="conteudo-esquerda">
            <p>Bem vindo à nossa empresa, líder no mercado de venda de camisas de times! Somos apaixonados pelo futebol
                e
                entendemos a importância de vestir a camisa do seu clube favorito com orgulho e estilo. Com anos de
                experiência
                no ramo, nos tornamos referência quando se trata de oferecer aos nossos clientes uma ampla seleção de
                produtos
                autênticos e de alta qualidade.</p>

            <p>Na nossa empresa, acreditamos que as camisas de times vão além de simples peças de vestuário. Elas
                representam a
                história, a tradição e a identidade dos clubes, além de serem símbolos de união e paixão dos torcedores.
                Por
                isso, buscamos constantemente trazer aos nossos clientes as camisas mais recentes e clássicas dos times
                mais
                populares do mundo.</p>

            <p>Nossa equipe é formada por especialistas no mercado esportivo, que estão sempre antenados às últimas
                tendências e
                novidades. Trabalhamos em parceria com os principais fabricantes de camisas de times, garantindo que
                cada
                produto que vendemos seja autêntico e de alta qualidade. Entendemos a importância de oferecer aos nossos
                clientes uma experiência de compra segura e confiável, por isso trabalhamos apenas com fornecedores
                reconhecidos
                e licenciados.</p>

            <p>Além da qualidade dos produtos, estamos comprometidos em proporcionar um excelente atendimento ao
                cliente.
                Nossa
                equipe está pronta para ajudar e responder a todas as suas perguntas, desde a escolha da camisa perfeita
                até
                o
                acompanhamento do seu pedido. Valorizamos cada cliente e buscamos superar suas expectativas, garantindo
                uma
                experiência de compra agradável e satisfatória.</p>
        </div>
        <div class="conteudo-direita">
            <p>No nosso site, você encontrará uma ampla variedade de camisas de times, desde as tradicionais até as mais
                recentes. Trabalhamos com clubes brasileiros, para que você possa encontrar a camisa do
                seu
                time
                favorito sem dificuldades. Além disso, oferecemos tamanhos para adultos e crianças, para que toda a
                família
                possa torcer junto.</p>

            <p>Nosso compromisso vai além da venda de camisas de times. Acreditamos na responsabilidade social e
                ambiental,
                por
                isso buscamos minimizar nosso impacto no meio ambiente através de práticas sustentáveis. Utilizamos
                embalagens
                recicláveis e trabalhamos com parceiros comprometidos com a preservação do planeta.</p>

            <p>Estamos ansiosos para ajudá-lo a encontrar a camisa perfeita e fazer parte da sua paixão pelo futebol.
                Convidamos
                você a explorar nosso site, conhecer nossa variedade de produtos e aproveitar nossas promoções
                especiais.
                Junte-se a nós e vista a camisa do seu time com orgulho!</p>
        </div>
    </div>

    <div class="container marketing">
    <div class="row">
        <div class="Integrantes text-center" style="margim-bottom: 20px;">
        <h1 style="margin-top: 30px">Integrantes do Projeto</h1>
        </div>
        <div class="col-lg-3 text-center">
            <svg class="bd-placeholder-img rounded-circle" width="140" height="140"
                xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder"
                preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Placeholder</title>
                <rect width="100%" height="100%" fill="var(--bs-secondary-color)" />
                <foreignObject width="100%" height="100%">
                    <img src="./assets/renato.jpg" alt="Imagem" width="140" height="140" class="mx-auto" />
                </foreignObject>
            </svg>
            <h2 class="fw-normal">Renato Carvalho</h2>
        </div>
        <div class="col-lg-3 text-center">
            <svg class="bd-placeholder-img rounded-circle" width="140" height="140"
                xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder"
                preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Placeholder</title>
                <rect width="100%" height="100%" fill="var(--bs-secondary-color)" />
                <foreignObject width="100%" height="100%">
                    <img src="./assets/dhomini2.jpg" alt="Imagem" width="140" height="140" class="mx-auto" />
                </foreignObject>
            </svg>
            <h2 class="fw-normal">Dhomini Pereira</h2>
        </div>
        <div class="col-lg-3 text-center">
            <svg class="bd-placeholder-img rounded-circle" width="140" height="140"
                xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder"
                preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Placeholder</title>
                <rect width="100%" height="100%" fill="var(--bs-secondary-color)" />
                <foreignObject width="100%" height="100%">
                    <img src="./assets/bernardo.jpg" alt="Imagem" width="140" height="140" class="mx-auto" />
                </foreignObject>
            </svg>
            <h2 class="fw-normal">Bernardo Cruz</h2>
        </div>
        <div class="col-lg-3 text-center">
            <svg class="bd-placeholder-img rounded-circle" width="140" height="140"
                xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder"
                preserveAspectRatio="xMidYMid slice" focusable="false">
                <title>Placeholder</title>
                <rect width="100%" height="100%" fill="var(--bs-secondary-color)" />
                <foreignObject width="100%" height="100%">
                    <img src="./assets/lucas.jpg" alt="Imagem" width="140" height="140" class="mx-auto" />
                </foreignObject>
            </svg>
            <h2 class="fw-normal">Lucas Ribeiro</h2>
        </div>
    </div>
</div>


</body>

</html>