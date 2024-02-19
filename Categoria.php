<?php
require "./config.php";

session_start();
if (!isset($_SESSION['usuario_id'])) {
  // Se não estiver autenticado, redireciona para a página de login
  header("Location: login.php");
  exit();
}

$usuarioId = $_SESSION['usuario_id'];


$sql = "SELECT * FROM categoria";
$sql = $pdo->prepare($sql);
$sql->execute();

$dados = $sql->fetchAll(PDO::FETCH_ASSOC);

// Obtém o capital do usuário
$sqlCapital = "SELECT capital FROM usuarios WHERE id = :usuarioId";
$queryCapital = $pdo->prepare($sqlCapital);
$queryCapital->bindParam(':usuarioId', $usuarioId);
$sqlCapital = "SELECT capital FROM usuarios WHERE id = :usuarioId";
$queryCapital = $pdo->prepare($sqlCapital);
$queryCapital->bindParam(':usuarioId', $usuarioId);
$queryCapital->execute();
$capital = $queryCapital->fetch(PDO::FETCH_ASSOC)['capital'];

$queryCapital->execute();

// Obter o resultado da consulta
$row = $queryCapital->fetch(PDO::FETCH_ASSOC);

// Se a consulta retornar resultados, use o valor do capital, caso contrário, defina como zero
$capital = ($row !== false) ? $row['capital'] : 0;
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
          <h4><a href="./login.php" class="">AccounTickles</a></h4>
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
          <p id="impressaoSaldo" class="ThGrid1-5 ">R$<?= number_format($capital, 2, ',', '.'); ?></p>
        </div>
      </div>
    </nav>
  </header>


  <main id="CorpoPagina" class="AlinhadoCen">
    <section class="Main-Section AlinhadoCen formulario">
      <form action="./cadastrarCategoria.php" method="get" class="Row1-5H AlinhadoCen">
        <div class="Parte1-5">
          <label>
            Descrição categoria
            <input type="text" name="descricao_categoria">
          </label>
        </div>
        <div class="Parte1-5">
          <button type="submit">Adicionar</button>
        </div>
      </form>

      <table id="TabelaGeral" class="AlinhadoCen Row1-2V">
        <thead class="MetadeVertical ">
          <tr class="Tr-TablePrincipal AlinhadoCen">
            <th class="ThGrid1-5 AlinhadoCen">ID</th>
            <th class="ThGrid1-5 AlinhadoCen">Descrição</th>
            <th class="ThGrid1-5 AlinhadoCen">Opções</th>
          </tr>
        </thead>
        <tbody class="MetadeVertical AreaRolagem">
          <?php foreach ($dados as $dado) : ?>
            <tr class="Tr-TablePrincipal AlinhadoCen">
              <td class="ThGrid1-5 AlinhadoCen"><?= $dado['id'] ?></td>
              <td class="ThGrid1-5 AlinhadoCen"><?= $dado['descricao'] ?></td>
              <td class="ThGrid1-5 AlinhadoCen">
                <a href="./excluirCategoria.php?id=<?= $dado['id'] ?>"><i class="fa-solid fa-trash"></i></a>
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
  <script>
    function verificarAntesExcluir() {
      var idParaExcluir = prompt("Informe o ID que deseja excluir:");

      if (!idParaExcluir) {
        return; // Cancelar se o usuário não fornecer um ID
      }

      // Verificar se o ID está presente nas tabelas de despesas ou receitas
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "verificarId.php?id=" + idParaExcluir, true);

      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          var resposta = JSON.parse(xhr.responseText);

          if (resposta.despesa || resposta.receita) {
            alert("Não é possível excluir o ID pois está presente em despesas ou receitas.");
          } else {
            // Se o ID não estiver nas tabelas, realizar a exclusão
            excluirCategoria(idParaExcluir);
          }
        }
      };

      xhr.send();
    }

    function excluirCategoria(id) {
      var xhrExcluir = new XMLHttpRequest();
      xhrExcluir.open("GET", "excluirCategoria.php?id=" + id, true);

      xhrExcluir.onreadystatechange = function() {
        if (xhrExcluir.readyState === 4 && xhrExcluir.status === 200) {
          alert("Categoria excluída com sucesso!");
          location.reload(); // Recarregar a página após a exclusão
        }
      };

      xhrExcluir.send();
    }
  </script>

</body>

</html>