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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/f2cd3193ae.js" crossorigin="anonymous"></script>
    <script src="scripts/cadastroForm"></script>
    <link href="style/login.css" rel="stylesheet">
</head>

<body>

    <!-------------------------- NAVBAR ---------------------------->

    <body>
        <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="assets/CC-SHIRT_logo.png" alt="Logo" height="55">

                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
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
                            <a id="drop" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
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

        <!-------------------------- AUTENTICAÇÃO ---------------------------->

        <?php
        include_once('php/conexao.php');

        if (
            isset($_POST['email']) ||
            isset($_POST['senha'])
        ) {
            $email = $mysqli->real_escape_string($_POST['email']);
            $senha = $mysqli->real_escape_string($_POST['senha']);

            $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";

            $sql_query = $mysqli->query($sql_code) or die('Erro ao consultar' + $mysqli->error);

            if ($sql_query->num_rows == 0) {
                echo '<div class="text-bg-danger p-3">Usuário ou senha incorreto.</div>';
            } else {
                $nome = $sql_query->fetch_assoc();
                $_SESSION['email'] = $email;
                $_SESSION['nome'] = $nome['nome'];
                header('location: index.php');
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isset($_GET['type'])) {
                if ($_GET['type'] == 'cadastro') {
                    if ($_GET['valor'] == 0) {
                        echo "<div class='text-bg-danger p-3'>Cadastro não efetuado.</div>";
                    } else if ($_GET['valor'] == 1) {
                        echo "<div class='text-bg-success p-3'>Cadastro efetuado com sucesso.</div>";
                    } else {
                        return;
                    }
                } else if (isset($_GET['type']) == 'alteracao') {
                    if ($_GET['valor'] == 0) {
                        echo "<div class='text-bg-danger p-3'>Alteração de senha não efetuada.</div>";
                    } else if ($_GET['valor'] == 1) {
                        echo "<div class='text-bg-success p-3'>Alteração de senha efetuada com sucesso.</div>";
                    }
                }
            }
        }
        ?>



        <!-------------------------- LOGIN ---------------------------->
        <section class="vh-100">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6 text-black">

                        <div class="px-5 ms-xl-4" style="margin-top: 50px">
                            <span class="h1 fw-bold mb-0">CC-Shirt</span>
                        </div>

                        <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

                            <form style="width: 23rem;" method="POST" action="">

                                <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Log in</h3>

                                <div class="form-outline mb-4">
                                    <input type="email" name="email" autocomplete="off" class="form-control"
                                        id="floatingInput" />
                                    <label class="form-label" for="floatingInput">Endereço de e-mail</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" name="senha" class="form-control" id="floatingPassword"
                                        required>
                                    <label class="form-label" for="floatingPassword">senha</label>
                                </div>
                                <input type="submit" value="Login">
                                <p class="small mb-5 pb-lg-2">
                                    <a class="text-muted" href="#!" data-bs-toggle="modal"
                                        data-bs-target="#alterarSenhaModal">Esqueceu a senha ?</a>
                                </p>
                                <p>Não possue uma conta ? <a href="#" class="link-info" data-bs-toggle="modal"
                                        data-bs-target="#cadastroModal">Cadastre-se aqui</a></p>

                            </form>

                        </div>

                        <!--CARROSSEL DE IMAGENS -->
                    </div>
                    <div class="col-sm-6 px-0 d-none d-sm-block">
                        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="assets/camisa-login_fla.webp" class="d-block w-100" alt="Imagem 1">
                                </div>
                                <div class="carousel-item">
                                    <img src="assets/camisa-login_flu.webp" class="d-block w-100" alt="Imagem 2">
                                </div>
                                <div class="carousel-item">
                                    <img src="assets/camisa-login_botafogo.webp" class="d-block w-100" alt="Imagem 3">
                                </div>
                                <div class="carousel-item">
                                    <img src="assets/camisa-login_vasco.webp" class="d-block w-100" alt="Imagem 4">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Próximo</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal de Cadastro -->

        <div class="modal fade" id="cadastroModal" tabindex="-1" aria-labelledby="cadastroModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100" id="cadastroModalLabel">Cadastro das informações</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3" action="php/cadastro.php" method="POST"
                            onsubmit="return validarFormulario()">
                            <div class="form-floating mb-3">
                                <input type="text" name="nome" pattern="[a-zA-ZÀ-ÿ\s]+" autocomplete="off"
                                    class="form-control <?php echo isset($_GET['field']) && $_GET['field'] == 'nome' && $_GET['valor'] == 0 ? 'is-invalid' : ''; ?>"
                                    id="nomeInput" placeholder="Digite seu nome" required>
                                <label for="nomeInput">Nome</label>
                                <?php if (isset($_GET['field']) && $_GET['field'] == 'nome' && $_GET['valor'] == 0): ?>
                                    <small class="text-danger">Erro ao cadastrar o nome.</small>
                                <?php else: ?>
                                    <small class="text-muted">Digite apenas letras no campo do nome.</small>
                                <?php endif; ?>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" name="email" autocomplete="off"
                                    class="form-control <?php echo isset($_GET['field']) && $_GET['field'] == 'email' && $_GET['valor'] == 0 ? 'is-invalid' : ''; ?>"
                                    id="emailInput" placeholder="Digite seu E-Mail" required>
                                <label for="emailInput">E-Mail</label>
                                <?php if (isset($_GET['field']) && $_GET['field'] == 'email' && $_GET['valor'] == 0): ?>
                                    <small class="text-danger">Erro ao cadastrar o e-mail.</small>
                                <?php else: ?>
                                    <small class="text-muted">Digite um endereço de email válido.</small>
                                <?php endif; ?>
                            </div>
                            <div class="form-floating">
                                <input type="password" name="senha" autocomplete="off" class="form-control"
                                    id="senhaInput" placeholder="Digite sua senha" required
                                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$">
                                <label for="senhaInput">Senha</label>
                                <?php if (isset($_GET['field']) && $_GET['field'] == 'senha' && $_GET['valor'] == 0): ?>
                                    <small class="text-danger">Erro ao cadastrar a senha.</small>
                                <?php else: ?>
                                    <small class="text-muted">A senha deve conter pelo menos 8 caracteres, uma letra
                                        maiúscula,
                                        uma letra minúscula, um número e um caractere especial.</small>
                                <?php endif; ?>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="endereco" autocomplete="off" class="form-control"
                                    id="enderecoInput" placeholder="Digite seu endereço" required>
                                <label for="enderecoInput">Endereço</label>
                                <?php if (isset($_GET['field']) && $_GET['field'] == 'endereco' && $_GET['valor'] == 0): ?>
                                    <small class="text-danger">Erro ao cadastrar o endereço.</small>
                                <?php else: ?>
                                    <small class="text-muted">Digite seu endereço completo.</small>
                                <?php endif; ?>
                            </div>
                            <br />
                            <button type="submit" class="btn btn-primary" name="cadastrar"
                                value="Cadastrar">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <!-- Modal de Alteração de Senha -->
        <div class="modal fade" id="alterarSenhaModal" tabindex="-1" aria-labelledby="alterarSenhaModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="alterarSenhaModalLabel">Alterar Senha</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <form action="php/alterar_senha.php" method="POST" id="alterarSenhaForm">
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="novaSenha" class="form-label">Nova Senha</label>
                                <input type="password" class="form-control" id="novaSenha" name="novaSenha"
                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                                title="A senha deve conter pelo menos 8 caracteres, uma letra maiúscula, uma letra
                                minúscula, um número e um caractere especial."
                                required>
                            </div>
                            <button type="submit" class="btn btn-primary">Alterar Senha</button>
                        </form>
                    </div>

                    <!-- Modal de Sucesso -->
                    <div class="modal fade" id="senhaAtualizadaModal" tabindex="-1"
                        aria-labelledby="senhaAtualizadaModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="senhaAtualizadaModalLabel">Senha Atualizada</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Fechar"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-success">Senha atualizada com sucesso!</p>
                                </div>
                            </div>
                        </div>
                    </div>
    </body>

</html>
</body>

</html>