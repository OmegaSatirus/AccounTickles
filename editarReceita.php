<?php
require "./config.php";

$id = $_GET['id'];
$sql = "SELECT * FROM receitas WHERE id = :id";
$sql = $pdo->prepare($sql);
$sql->bindValue(":id", $id);
$sql->execute();
$item = $sql->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM receitas";
$sql = $pdo->prepare($sql);
$sql->execute();
$dados = $sql->fetchAll(PDO::FETCH_ASSOC);
$sql = "SELECT r.*, c.descricao as categoria_descricao FROM receitas r
        LEFT JOIN categoria c ON r.categoria_id = c.id";
$query = $pdo->prepare($sql);
$query->execute();

$dados = $query->fetchAll(PDO::FETCH_ASSOC);

$sqlCat = "SELECT descricao FROM categoria";
$queryCat = $pdo->prepare($sqlCat);
$queryCat->execute();
$result = $queryCat->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receitas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
    <header id="MainHeader">
        <nav>
            <div class="Tr-TablePrincipal AlinhadoCen">
                <div id="logo" class="ThGrid1-5">
                    <h2>AccounTickles</h2>
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
                    <h2 class="ThGrid1-5">R$310</h2>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section class="formulario">
            <form action="./confirmarEditarReceita.php" method="get">

                <input type="hidden" name="id" value="<?= $id; ?>">

                <label>
                    Descrição
                    <input type="text" name="descricao" value="<?= $item['descricao'] ?>">
                </label>

                <label>
                    Valor
                    <input type="number" name="valor" value="<?= $item['valor']; ?>">
                </label>

                <label>
                    Categoria
                    <select id="descricao_categoria" name="descricao_categoria">
                        <?php
                        // Verificar se há resultados na consulta
                        if ($result) {
                            // Loop através dos resultados
                            foreach ($result as $row) :
                                // Adicionar uma opção para cada descrição
                                echo "<option value='" . $row['descricao'] . "'>" . $row['descricao'] . "</option>";
                            endforeach;
                        } else {
                            echo "<option value=''>Nenhum dado encontrado</option>";
                        }
                        ?>
                    </select>
                </label>

                <label>
                    Data
                    <input type="date" name="data_mvto" value="<?= $item['data_mvto'] ?>">
                </label>

                <button type="submit">Editar</button>
            </form>
        </section>

        <section class="tabela">
            <!-- Sua tabela e código PHP para exibir dados -->
        </section>
    </main>

    <script src="https://kit.fontawesome.com/561265e797.js" crossorigin="anonymous"></script>
</body>

</html>