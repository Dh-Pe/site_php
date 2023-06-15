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
    <link rel="stylesheet" href="style/carrinho.css">
    <!-- Importe o Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Linkando com a Função -->
    <script src="scripts/rmcarrinho.js"></script>
    <!-- Função pagamento -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                            <a class="nav-link icone" href="comentarios.php">Comentários</a>
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

        <!-------------------------- TÍTULO ---------------------------->

        <h1 class="title">
            <i class="fas fa-shopping-cart"></i> <span>Carrinho</span>
        </h1>

        <!-------------------------- LISTA DE PRODUTOS ---------------------------->

        <div class="cards">

            <?php
            include_once('php/conexao.php');

            if (isset($_POST['pesquisa'])) {
                $pesquisa = $mysqli->real_escape_string($_POST['pesquisa']);

                $sql_query = $mysqli->query("SELECT p.nome, p.imageURL, p.descricao, p.preco, c.quantidade, p.id
                        FROM carrinhos c
                            JOIN produtos p
                                ON c.id_produto = p.id
                                WHERE c.email_usuario = '$email'
                                    AND c.quantidade > 0
                                    AND c.comprado = false
                                    AND p.nome LIKE '%$pesquisa%'") or die('Erro ao consultar' + $mysqli->error);

                if ($sql_query->num_rows > 0) {
                    while ($dados = $sql_query->fetch_assoc()) {
                        ?>
                        <div class="card">
                            <img src="<?php
                            echo $dados['imageURL'];
                            ?>" class="card-img-top" alt="...">

                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php
                                    echo $dados['nome'];
                                    ?>
                                </h5>
                                <h6>
                                    <?php
                                    echo number_format($dados['preco'], 2, ',', '.') . ' R$';
                                    ?>
                                </h6>
                                <p class="card-text">
                                    <?php
                                    echo 'Quantidade: ' . $dados['quantidade'];
                                    ?>
                                </p>
                                <div class="card-buttons">
                                    <button type="button" id="<?php
                                    echo $dados['id'];
                                    ?>" onclick="removerDoCarrinho(this)" class="btn btn-dark">Remover do carrinho <i
                                            class="fa-solid fa-cart-shopping"></i></button>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else
                    echo '<h3>Nada foi encontrado no carrinho</h3>';
            } else {
                $sql_query = $mysqli->query("SELECT p.nome, p.imageURL, p.descricao, p.preco, c.quantidade, p.id
                        FROM carrinhos c
                            JOIN produtos p
                                ON c.id_produto = p.id
                                WHERE c.email_usuario = '$email'
                                    AND c.comprado = false
                                    AND c.quantidade > 0;") or die('Erro ao consultar' + $mysqli->error);

                if ($sql_query->num_rows == 0) {
                    echo '<h3>Seu carrinho está vazio</h3>';
                } else {
                    while ($dados = $sql_query->fetch_assoc()) {
                        ?>
                        <div class="card">
                            <img src="<?php
                            echo $dados['imageURL'];
                            ?>" class="card-img-top" alt="<?php
                            echo $dados['nome'];
                            ?>">

                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php
                                    echo $dados['nome'];
                                    ?>
                                </h5>
                                <h6>
                                    <?php
                                    echo number_format($dados['preco'], 2, ',', '.') . ' R$';
                                    ?>
                                </h6>
                                <p class="card-text">
                                    <?php
                                    echo 'Quantidade: ' . $dados['quantidade'];
                                    ?>
                                </p>
                                <div class="card-buttons">
                                    <button type="button" id="<?php
                                    echo $dados['id'];
                                    ?>" onclick="removerDoCarrinho(this)" class="btn btn-dark">Remover do carrinho <i
                                            class="fa-solid fa-cart-shopping"></i></button>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
            ?>
        </div>

        <!-- Button trigger modal -->
        <div class="botao">
            <?php
            if ($sql_query->num_rows == 0) {
                // Carrinho vazio, exibe o modal
                echo '<button type="button" class="btn btn-Success payment-button" data-bs-toggle="modal" data-bs-target="#emptyCartModal">';
            } else {
                // Carrinho não vazio, botão de pagamento normal
                echo '<button type="button" class="btn btn-Success payment-button" data-bs-toggle="modal" data-bs-target="#ValorTotal">';
            }
            ?>
            <i class="fa-solid fa-money-bill-wave"></i>
            <span class="payment-button-text">Comprar</span>
            </button>
        </div>


        <!-- Modal Carrinho vazio-->
        <div class="modal fade" id="emptyCartModal" tabindex="-1" aria-labelledby="emptyCartModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100" id="emptyCartModalLabel">Carrinho Vazio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Seu carrinho está vazio. Adicione um produto antes de prosseguir com o pagamento.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Valor total -->
        <div class="modal fade" id="ValorTotal" tabindex="-1" aria-labelledby="ValorTotalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title w-100" id="ValorTotalLabel">Total a pagar</h5>
                    </div>
                    <div class="modal-body">
                        <p>
                            <?php
                            $sql_query = $mysqli->query("SELECT p.preco, c.quantidade
                            FROM carrinhos c
                                JOIN produtos p
                                    ON c.id_produto = p.id
                                    WHERE c.email_usuario = '$email'
                                        AND c.comprado = false
                                        AND c.quantidade > 0;");

                            $somatotal = 0;
                            while ($valores = $sql_query->fetch_assoc()) {
                                $somatotal = $somatotal + ($valores['preco'] * $valores['quantidade']);
                            }
                            echo 'Valor: ' . number_format($somatotal) . ' R$ <br/>';
                            echo 'Prazo de entrega: 5 dias';
                            ?>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-modal" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-success btn-modal" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">Prosseguir</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Forma de pagamento -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-header-no-close">
                        <h4 class="modal-title w-100" id="exampleModalLabel">Formas de pagamento</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="escolha-pagamento">
                            <p>Escolha a forma de pagamento:</p>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="forma-pagamento" id="cartao-radio"
                                    value="cartao">
                                <label class="form-check-label" for="cartao-radio">
                                    <i class="far fa-credit-card"></i> Cartão de Crédito
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-danger btn-modal" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-success btn-modal"
                            id="prosseguir-button">Prosseguir</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Cartão de crédito -->
        <div class="modal fade" id="prosseguir" tabindex="-1" aria-labelledby="prosseguirLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="h8 py-3">Detalhes do pagamento</div>
                        <div class="row gx-3">
                            <form action="php/addCompras.php" method="POST">
                                <div class="col-12">
                                    <div class="d-flex flex-column">
                                        <p class="text mb-1">Nome Completo</p>
                                        <input class="form-control mb-3" type="text" id="nomeCompleto"
                                            placeholder="Digite seu nome" required>
                                        <div class="text-danger" id="nomeCompletoError"></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex flex-column">
                                        <p class="text mb-1">Número do Cartão</p>
                                        <input class="form-control mb-3" type="text" id="numeroCartao"
                                            placeholder="0000 0000 0000 0000" required
                                            pattern="[0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}" maxlength="19">
                                        <div class="text-danger" id="numeroCartaoError"></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex flex-column">
                                        <p class="text mb-1">Validade</p>
                                        <input class="form-control mb-3" type="text" id="validade" placeholder="MM/YY"
                                            required maxlength="5">
                                        <div class="text-danger" id="validadeError"></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex flex-column">
                                        <p class="text mb-1">CVV/CVC</p>
                                        <input class="form-control mb-3 pt-2" type="password" id="cvv" placeholder="***"
                                            required pattern="[0-9]{3}" minlength="3" maxlength="3">
                                        <div class="text-danger" id="cvvError"></div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="btn btn-danger btn-modal btn-x1 me-3"
                                        data-bs-dismiss="modal"><i class="fas fa-arrow-left"></i>
                                        Cancelar</button>
                                    <button type="submit" class="btn btn-success btn-modal btn-x1 ml-2"
                                        id="btn-pagar">Pagar<i class="fas fa-arrow-right"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Escolha de pagamento: cartao ou Pix -->
        <script>
            document.getElementById("prosseguir-button").addEventListener("click", function () {
                var formaPagamento = document.querySelector('input[name="forma-pagamento"]:checked').value;

                if (formaPagamento === "cartao") {
                    $('#exampleModal').modal('hide');
                    $('#prosseguir').modal('show');
                }
            });
        </script>


        <!-- Formatação dos campos Cartão de crédito -->
        <script>
            function formatarCartao() {
                const numeroCartaoInput = document.getElementById('numeroCartao');
                let numeroCartao = numeroCartaoInput.value.trim().replace(/\s/g, '');

                if (numeroCartao.length > 0) {
                    numeroCartao = numeroCartao.match(new RegExp('.{1,4}', 'g')).join(' ');
                }

                numeroCartaoInput.value = numeroCartao;
            }

            // Evento para chamar a função de formatação quando o usuário digitar no campo do cartão
            document.getElementById('numeroCartao').addEventListener('input', formatarCartao);

            function formatarValidade() {
                const validadeInput = document.getElementById('validade');
                let validade = validadeInput.value.trim();

                if (validade.length > 0) {
                    validade = validade.replace(/\//g, ''); // Remove todas as barras existentes
                    validade = validade.match(new RegExp('.{1,2}', 'g')).join('/');
                    validade = validade.substr(0, 5);
                }

                validadeInput.value = validade;
            }

            // Evento para chamar a função de formatação quando o usuário digitar no campo da validade
            document.getElementById('validade').addEventListener('input', formatarValidade);
        </script>

        <script>
            $(document).ready(function () {
                $('#btn-pagar').click(function (event) {
                    var nomeCompleto = $('#nomeCompleto').val();
                    var numeroCartao = $('#numeroCartao').val();
                    var validade = $('#validade').val();
                    var cvv = $('#cvv').val();

                    var nomeValido = /^[a-zA-Z\s]+$/.test(nomeCompleto);
                    var numeroCartaoValido = /^[0-9]{4}\s?[0-9]{4}\s?[0-9]{4}\s?[0-9]{4}$/.test(numeroCartao);
                    var validadeValida = /^(0[1-9]|1[0-2])\/(0[1-9]|1[0-9]|2[0-9]|3[0-1])$/.test(validade);
                    var cvvValido = /^[0-9]{3}$/.test(cvv);

                    // Limpar mensagens de erro
                    $('#nomeCompletoError').text('');
                    $('#numeroCartaoError').text('');
                    $('#validadeError').text('');
                    $('#cvvError').text('');

                    var informacoesValidas = true;

                    if (!nomeValido) {
                        $('#nomeCompletoError').text('O nome deve conter apenas letras.');
                        informacoesValidas = false;
                    }

                    if (!numeroCartaoValido) {
                        $('#numeroCartaoError').text('O número do cartão deve estar no formato correto (exemplo: 0000 0000 0000 0000).');
                        informacoesValidas = false;
                    }

                    if (!validadeValida) {
                        $('#validadeError').text('A validade deve estar no formato correto (exemplo: 00/00).');
                        informacoesValidas = false;
                    }

                    if (!cvvValido) {
                        $('#cvvError').text('O CVV deve conter 3 dígitos numéricos.');
                        informacoesValidas = false;
                    }
                });
            });
        </script>


    </body>