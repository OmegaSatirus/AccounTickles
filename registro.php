<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login/Registro - AccounTickles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
    <header id="MainHeader">
        <nav>
            <div class="Tr-TablePrincipal AlinhadoCen">
                <div id="logo" class="ThGrid1-5">
                    <h4><a href="./registro.php" class="">AccounTickles</a></h4>
                </div>
            </div>
        </nav>
    </header>

    <main id="CorpoPagina" class="AlinhadoCen">
        <section class="AlinhadoCen" id="FormularioRegistro">
            <div class="Register">
                <h2>Registro</h2>
                <form action="processar_registro.php" method="post">
                    <div class="mb-3">
                        <label for="nomeRegistro" class="form-label">Nome:</label>
                        <input type="text" class="form-control" id="nomeRegistro" name="nomeRegistro" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailRegistro" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="emailRegistro" name="emailRegistro" required>
                    </div>
                    <div class="mb-3">
                        <label for="senhaRegistro" class="form-label">Senha:</label>
                        <input type="password" class="form-control" id="senhaRegistro" name="senhaRegistro" required>
                    </div>
                    <div class="mb-3">
                        <label for="capitalRegistro" class="form-label">Capital Inicial:</label>
                        <input type="number" class="form-control" id="capitalRegistro" name="capitalRegistro" required>
                    </div>
                    <div id="Reg-Log" class="Tr-TablePrincipal AlinhadoCen">
                        <div class="ThGrid1-5">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                        <div class="ThGrid1-5">
                            <a class="Fake-Button" href="./login.php">Login</a>
                        </div>
                    </div>
                </form>
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