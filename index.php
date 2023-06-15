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
  <link rel="stylesheet" type="text/css" href="style/index.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/f2cd3193ae.js" crossorigin="anonymous"></script>
  <script src="scripts/addcarrinho.js"></script>
</head>

<body>

  <!-------------------------- NAVBAR ---------------------------->

  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
          <img src="assets/CC-SHIRT_logo.png" alt="Logo" height="55">

        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active icone" href="index.php">Home</a>
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
          <form class="d-flex ms-auto" role="search" action="" method="POST">
            <input class="form-control me-2" type="search" autocomplete="off" name="pesquisa"
              placeholder="Pesquise aqui..." aria-label="Search">
          </form>
        </div>
      </div>
    </nav>

    <!-------------------------- SLIDE ---------------------------->

    <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel" data-bs-theme="light">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true"
          aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="./assets/slide-01.png" width="100%" height="70% auto"/>
          <div class="container">
            <div class="carousel-caption text-start">
              <h1>Cadastre-se</h1>
              <p class="opacity-75">Se cadastre no nosso site para receber informações de novos produtos e promoções
                sobre
                as camisas.</p>
              <p><a class="btn btn-lg btn-primary" href="login.php">Cadastre-se</a></p>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <img src="./assets/slide-02.jpeg" width="100%" height="70% auto" />
          <div class="container">
            <div class="carousel-caption">
              <h1>Sobre nós.</h1>
              <p class="opacity-75">Estamos no Top-1 de melhores sites de venda de camisas esportivas do Brasil, venha também comprar o seu
                manto sagrado, a sua armadura ou a sua camisa7</p>
              <p><a class="btn btn-lg btn-primary" href="sobrenos.php">Ler mais</a></p>
            </div>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <!------------------- Exemplos ------------------->

    <h1 class="title">
      <i class="fa-solid fa-shirt"></i> <span>Feedbacks</span>
    </h1>

    <div class="row mb-2">
      <?php
      include_once('php/conexao.php');
      $sql_query = $mysqli->query("SELECT u.nome, c.data, c.comentario FROM comentarios c JOIN usuarios u ON c.email_usuario = u.email ORDER BY data DESC LIMIT 2") or die('Erro na consulta: ' . $mysqli->error);

      while ($dados = $sql_query->fetch_assoc()) {
        $timestamp = strtotime($dados['data']);
        $dataFormatada = date('d/m/Y - H:i', $timestamp);

        echo '<div class="col-md-6">';
        echo '<div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">';
        echo '<div class="col p-4 d-flex flex-column position-static">';
        echo '<strong class="d-inline-block mb-2 text-primary-emphasis">Feedback</strong>';
        echo '<h3 class="mb-0">';
        echo $dados['nome'];
        echo '</h3>';
        echo '<div class="mb-1 text-body-secondary">' . $dataFormatada . '</div>';
        echo '<p class="card-text mb-auto">' . $dados['comentario'] . '</p>';
        echo '<a href="contato.php" class="icon-link gap-1 icon-link-hover">';
        echo 'Continue lendo';
        echo '</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      }
      ?>
    </div>

    <hr class="border border-dark border-3 opacity-75">

    <h1 class="title">
      <i class="fa-solid fa-shirt"></i> <span>Produtos</span>
    </h1>

    <div class="cards">
      <?php
      include_once('php/conexao.php');

      if (isset($_POST['pesquisa'])) {
        $pesquisa = $mysqli->real_escape_string($_POST['pesquisa']);

        $sql_code = "SELECT * FROM produtos WHERE nome LIKE '%$pesquisa%'";

        $sql_query = $mysqli->query($sql_code) or die('Erro ao consultar' + $mysqli->error);

        if ($sql_query->num_rows == 0)
          echo "<div class='alert alert-danger' role='alert'>Nenhum produto foi encontrado.</div>";
        while ($dados = $sql_query->fetch_assoc()) {
          ?>
      <div class="card">
        <img src="<?php echo $dados['imageURL'] ?>" class="card-img-top" alt="<?php echo $dados['nome'] ?>">

        <div class="card-body">
          <h5 class="card-title">
            <?php echo $dados['nome'] ?>
          </h5>
          <h6>
            <?php echo number_format($dados['preco'], 2, ',', '.') . ' R$' ?>
          </h6>
          <p class="card-text">
            <?php echo $dados['descricao'] ?>
          </p>
          <div class="card-buttons text-center">
            <button type="button" id="<?php echo $dados['id'] ?>" onclick="adicionarAoCarrinho(this)"
              class="btn btn-dark add-to-cart-btn addcarrinho">
              Adicionar ao carrinho
              <i class="fa-solid fa-cart-shopping"></i>
            </button>
          </div>
        </div>
      </div>
      <?php
        }
      } else {
        $sql_code = "SELECT * FROM produtos ORDER BY id";

        $sql_query = $mysqli->query($sql_code) or die('Erro ao consultar' + $mysqli->error);

        while ($dados = $sql_query->fetch_assoc()) {
          ?>
      <div class="card">
        <img src="<?php echo $dados['imageURL'] ?>" class="card-img-top" alt="<?php echo $dados['nome'] ?>">

        <div class="card-body">
          <h5 class="card-title">
            <?php echo $dados['nome'] ?>
          </h5>
          <h6>
            <?php echo number_format($dados['preco'], 2, ',', '.') . ' R$' ?>
          </h6>
          <p class="card-text">
            <?php echo $dados['descricao'] ?>
          </p>
          <div class="card-buttons text-center">
            <button type="button" id="<?php echo $dados['id'] ?>" onclick="adicionarAoCarrinho(this)"
              class="btn btn-dark add-to-cart-btn addcarrinho">
              Adicionar ao carrinho
              <i class="fa-solid fa-cart-shopping ms-2"></i>
            </button>
          </div>
        </div>
      </div>
      <?php
        }
      }
      ?>
    </div>
  </body>

</html>