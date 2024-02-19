<?php
<<<<<<< HEAD
require "./config.php";

$sql = "SELECT * FROM receitas";
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
      <ul class="RowFake AlinhadoCen">
        <li><a class="Fake-Button" href="./receitas.php">Receitas</a></li>
        <li><a class="Fake-Button" href="./teste.php">Despesas</a></li>
        <li><a class="Fake-Button" href="./Categoria.php">Categorias</a></li>
      </ul>
    </nav>
  </header>

  <main id="CorpoPagina" class="AlinhadoCen">
    <section class="Main-Section AlinhadoCen formulario">
      <form action="./cadastrarReceita.php" method="get" class="Row1-5H AlinhadoCen">
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
            Categoria
            <select id="descricao" name="descricao">
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
          <button type="submit">Adicionar</button>
        </div>
      </form>

      <table id="TabelaGeral" class="AlinhadoCen Row1-2V">
        <thead class="MetadeVertical">
          <tr class="Tr-TablePrincipal">
            <th class="ThGrid1-5 AlinhadoCen">Posição</th>
            <th class="ThGrid1-5 AlinhadoCen">ID</th>
            <th class="ThGrid1-5 AlinhadoCen">Descrição</th>
            <th class="ThGrid1-5 AlinhadoCen">Categoria</th>
            <th class="ThGrid1-5 AlinhadoCen">Valor</th>
            <th class="ThGrid1-5 AlinhadoCen">Data</th>
            <th class="ThGrid1-5 AlinhadoCen">Opções</th>
          </tr>
        </thead>
        <tbody class="MetadeVertical AreaRolagem">
          <?php foreach ($dados as $cont => $dado) : ?>
            <tr class="Tr-TablePrincipal">
              <td class="ThGrid1-5 AlinhadoCen"><?= $cont + 1 ?></td>
              <td class="ThGrid1-5 AlinhadoCen"><?= $dado['id'] ?></td>
              <td class="ThGrid1-5 AlinhadoCen"><?= $dado['descricao'] ?></td>
              <td class="ThGrid1-5 AlinhadoCen"><?= $dado['categoria_id'] ?></td>
              <td class="ThGrid1-5 AlinhadoCen"><?= $dado['valor'] ?></td>
              <td class="ThGrid1-5 AlinhadoCen"><?= $dado['data_mvto'] ?></td>
              <td class="ThGrid1-5 AlinhadoCen">
                <a href="./deletar.php?id=<?= $dado['id'] ?>"><i class="fa-solid fa-trash"></i></a>
                <a href="./editarReceita.php?id=<?= $dado['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  </main>
  <footer id="MainFooter">
    <p>Ouça Febem!</p>
  </footer>


  <!-- Modal de Edição -->
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
            <input type="hidden" name="id" id="editId">
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
=======
// Substitua as informações do banco de dados
$servername = "5ps.site";
$username = "hg5pss68_bntds_vermelho";
$password = "$!-MpY&G)f*p";
$dbname = "hg5pss68_bntds_vermelho";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Consulta para obter os dados da coluna 'descricao'
$sql = "SELECT descricao FROM categoria";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Exemplo Select</title>
</head>
<body>

    <form>
        <label for="descricao">Selecione uma opção:</label>
        <select id="descricao" name="descricao">
            <?php
            // Verificar se há resultados na consulta
            if ($result->num_rows > 0) {
                // Loop através dos resultados
                while($row = $result->fetch_assoc()) {
                    // Adicionar uma opção para cada descrição
                    echo "<option value='" . $row['descricao'] . "'>" . $row['descricao'] . "</option>";
                }
            } else {
                echo "<option value=''>Nenhum dado encontrado</option>";
            }
            ?>
        </select>
    </form>

<?php
// Fechar conexão com o banco de dados
$conn->close();
?>

</body>
</html>
>>>>>>> 7dd9ebdf6686c22e22e04cf223f7e7636d147445
