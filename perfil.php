<?php
require "./config.php";

// Verifica se o usuário está autenticado
session_start();
if (!isset($_SESSION['usuario_id'])) {
    // Se não estiver autenticado, redireciona para a página de login
    header("Location: login.php");
    exit();
}

// Obtém informações do usuário autenticado
$usuarioId = $_SESSION['usuario_id'];
$sqlPerfil = "SELECT nome, email, capital FROM usuarios WHERE id = :usuarioId";
$queryPerfil = $pdo->prepare($sqlPerfil);
$queryPerfil->bindParam(':usuarioId', $usuarioId);
$queryPerfil->execute();
$perfil = $queryPerfil->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Perfil - AccounTickles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
    <header id="MainHeader">
        <nav>
            <div class="Tr-TablePrincipal AlinhadoCen">
                <div id="logo" class="ThGrid1-5">
                    <h2><a href="./registro.php" class="">AccounTickles</a></h2>
                </div>
                <div class="ThGrid1-5">

                </div>
                <ul class="RowFake AlinhadoCen ThGrid1-5">
                    <li><a class="Fake-Button" href="./receitas.php">Receitas</a></li>
                    <li><a class="Fake-Button" href="./despesas.php">Despesas</a></li>
                    <li><a class="Fake-Button" href="./Categoria.php">Categorias</a></li>
                </ul>
                <div class="ThGrid1-5">

                </div>
                <div id="Saldo" class="ThGrid1-5 Tr-TablePrincipal AlinhadoCen">
                    <a href="./perfil.php" class="ThGrid1-5">
                        <h4><i class="fa-solid fa-person"></i></h4>
                    </a>
                    <p id="ImpressaoSaldo" class="ThGrid1-5">R$ <?php echo number_format($perfil['capital'], 2, ',', '.'); ?></p>
                </div>
            </div>
        </nav>
    </header>

    <main id="CorpoPagina" class="AlinhadoCen">
        <section id="profile" class="Main-Section AlinhadoCen">
            <div class="container">
                <h2>Perfil</h2>
                <p>Nome: <?php echo $perfil['nome']; ?></p>
                <p>Email: <?php echo $perfil['email']; ?></p>
                <p>Capital: R$ <?php echo number_format($perfil['capital'], 2, ',', '.'); ?></p>
            </div>
        </section>
    </main>

    <footer id="MainFooter">
        <p>Ouça Febem!</p>
    </footer>

    <script src="https://kit.fontawesome.com/561265e797.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>