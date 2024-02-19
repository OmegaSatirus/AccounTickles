<?php
require "./config.php";

session_start();
if (!isset($_SESSION['usuario_id'])) {
    // Se não estiver autenticado, redireciona para a página de login
    header("Location: login.php");
    exit();
}

$usuarioId = $_SESSION['usuario_id'];

// Obtém o capital do usuário
$sqlCapital = "SELECT capital FROM usuarios WHERE id = :usuarioId";
$queryCapital = $pdo->prepare($sqlCapital);
$queryCapital->bindParam(':usuarioId', $usuarioId);
$queryCapital->execute();
$capital = $queryCapital->fetch(PDO::FETCH_ASSOC)['capital'];


$sql = "SELECT d.*, c.descricao as categoria_descricao FROM despesa d
        LEFT JOIN categoria c ON d.id_categoria = c.id";
$query = $pdo->prepare($sql);
$query->execute();

$dados = $query->fetchAll(PDO::FETCH_ASSOC);

// Se a consulta retornar resultados, use o valor do capital, caso contrário, defina como zero
$capital = ($capital !== false) ? $capital : 0;

$sqlDespesas = "SELECT d.*, c.descricao as categoria_descricao FROM despesa d
        LEFT JOIN categoria c ON d.id_categoria = c.id";
$queryDespesas = $pdo->prepare($sqlDespesas);
$queryDespesas->execute();
$dadosDespesas = $queryDespesas->fetchAll(PDO::FETCH_ASSOC);

foreach ($dadosDespesas as $despesa) {
    // Verifica se a despesa está paga antes de subtrair do capital
    if ($despesa['status_pago'] == 1) {
        $capital -= $despesa['valor'];
    }
}

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

    <title>Despesas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
    <header id="MainHeader">
        <nav>
            <div class="Tr-TablePrincipal AlinhadoCen">
                <div id="logo" class="ThGrid1-5">
                    <h2><a href="./login.php" class="">AccounTickles</a></h2>
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
                    <h2 id="impressaoSaldo" class="ThGrid1-5 ">R$<?= number_format($capital, 2, ',', '.'); ?></h2>
                </div>
            </div>
        </nav>
    </header>

    <main id="CorpoPagina" class="AlinhadoCen">
        <section class="Main-Section AlinhadoCen formulario">
            <form action="./cadastrarDespesa.php" method="post" class="Row1-5H AlinhadoCen">
                <div class="Parte1-5">
                    <label>
                        Descrição
                        <input type="text" required name="descricao">
                    </label>
                </div>
                <div class="Parte1-5">
                    <label>
                        Valor
                        <input type="number" min="0" name="valor">
                    </label>
                </div>
                <div class="Parte1-5">
                    <label>
                        Categoria <br>
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
                </div>

                <div class="Parte1-5">
                    <label>
                        Data <br>
                        <input type="date" required name="data_mvto">
                    </label>
                </div>
                <div class="Parte1-5">
                    <label>
                        Status Pago <br>
                        <select id="status_pago" name="status_pago">
                            <option value="1">Pago</option>
                            <option value="0">Não Pago</option>
                        </select>
                    </label>
                </div>
                <div class="Parte1-5">
                    <button type="submit">Adicionar</button>
                </div>
            </form>

            <table id="TabelaGeral" class="AlinhadoCen Row1-2V">
                <thead class="MetadeVertical">
                    <tr class="Tr-TablePrincipal">
                        <th class="ThGrid1-5 AlinhadoCen">ID</th>
                        <th class="ThGrid1-5 AlinhadoCen">Descrição</th>
                        <th class="ThGrid1-5 AlinhadoCen">Categoria</th>
                        <th class="ThGrid1-5 AlinhadoCen">Valor</th>
                        <th class="ThGrid1-5 AlinhadoCen">Data</th>
                        <th class="ThGrid1-5 AlinhadoCen">Status Pago</th>
                        <th class="ThGrid1-5 AlinhadoCen">Opções</th>
                    </tr>
                </thead>
                <tbody class="MetadeVertical AreaRolagem">
                    <?php foreach ($dados as $cont => $dado) : ?>
                        <tr class="Tr-TablePrincipal">
                            <td class="ThGrid1-5 AlinhadoCen"><?= $dado['id'] ?></td>
                            <td class="ThGrid1-5 AlinhadoCen"><?= $dado['descricao'] ?></td>
                            <td class="ThGrid1-5 AlinhadoCen"><?= $dado['categoria_descricao'] ?></td>
                            <td class="ThGrid1-5 AlinhadoCen"><?= $dado['valor'] ?></td>
                            <td class="ThGrid1-5 AlinhadoCen"><?= $dado['data_mvto'] ?></td>
                            <td class="ThGrid1-5 AlinhadoCen"><?= $dado['status_pago'] ? 'Pago' : 'Não Pago' ?></td>
                            <td class="ThGrid1-5 AlinhadoCen">
                                <a href="./deletarDespesa.php?id=<?= $dado['id'] ?>"><i class="fa-solid fa-trash"></i></a>
                                <a href="./editarDespesa.php?id=<?= $dado['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

            </table>
        </section>
    </main>
    <footer id="MainFooter">
        <p>Ouça Febem!</p>
    </footer>

    <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarModalLabel">Editar Receita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulário de Edição -->
                    <form id="formEdicao" action="./editar.php" method="post">
                        <input type="hidden" name="categoria_hidden" id="categoria_hidden" value="">
                        <label>
                            Descrição
                            <input type="text" name="descricao" id="editDescricao">
                        </label>

                        <label>
                            Valor
                            <input type="number" name="valor" id="editValor">
                        </label>

                        <label>
                            Data
                            <input type="date" name="data_mvto" id="editData">
                        </label>

                        <button type="submit" class="btn btn-primary">Salvar Edição</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/561265e797.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function sortTable(columnIndex) {
            var table, rows, switching, i, x, y, shouldSwitch, sortOrder;
            table = document.getElementById("TabelaGeral");
            switching = true;

            // Obter a ordem atual da coluna
            sortOrder = table.getAttribute('data-sort-order') === 'asc' ? 'desc' : 'asc';

            while (switching) {
                switching = false;
                rows = table.rows;

                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;

                    // Ignorar a primeira coluna (Posição)
                    if (columnIndex !== 0) {
                        x = rows[i].getElementsByTagName("td")[columnIndex];
                        y = rows[i + 1].getElementsByTagName("td")[columnIndex];

                        if (columnIndex === 5) { // Índice da coluna 'Data'
                            x = new Date(x.textContent);
                            y = new Date(y.textContent);
                        } else {
                            x = parseFloat(x.textContent);
                            y = parseFloat(y.textContent);
                        }

                        if ((sortOrder === 'asc' && x > y) || (sortOrder === 'desc' && x < y)) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }

                if (shouldSwitch) {
                    // Manter a coluna "Posição" fixa
                    var temp = rows[i].cells[0].innerHTML;
                    rows[i].cells[0].innerHTML = rows[i + 1].cells[0].innerHTML;
                    rows[i + 1].cells[0].innerHTML = temp;

                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }

            // Alternar a ordem atual
            table.setAttribute('data-sort-order', sortOrder);
        }

        document.addEventListener('DOMContentLoaded', function() {
            var headers = document.querySelectorAll('#TabelaGeral th');
            headers.forEach(function(header, index) {
                header.setAttribute('data-column', index);
                header.addEventListener('click', function() {
                    sortTable(index);
                });
            });
        });
    </script>
</body>

</html>