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
        <section class="AlinhadoCen" id="FormularioLogin">
            <div class="login">
                <h2>Login</h2>
                <form action="processar_login.php" method="post">
                    <div class="mb-3">
                        <label for="emailLogin" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="emailLogin" name="emailLogin" required>
                    </div>
                    <div class="mb-3">
                        <label for="senhaLogin" class="form-label">Senha:</label>
                        <input type="password" class="form-control" id="senhaLogin" name="senhaLogin" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Entrar</button>
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