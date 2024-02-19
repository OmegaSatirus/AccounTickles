<?php
require "config.php";

$id = $_GET['id'];

// Obter os dados da URL
$descricao = $_GET['descricao'];
$valor = $_GET['valor'];
$data_mvto = $_GET['data_mvto'];
$descricao_categoria = isset($_GET['descricao_categoria']) ? $_GET['descricao_categoria'] : '';

// Obter o ID da categoria com base na descrição selecionada
$sqlCatId = "SELECT id FROM categoria WHERE descricao = :descricao_categoria";
$queryCatId = $pdo->prepare($sqlCatId);
$queryCatId->bindValue(":descricao_categoria", $descricao_categoria);
$queryCatId->execute();
$categoria = $queryCatId->fetch(PDO::FETCH_ASSOC);

if ($categoria === false) {
  // Tratar o caso em que a categoria não foi encontrada
  echo "Categoria não encontrada";
  exit;
}

// Restante do código para a execução da atualização


// Atualizar os dados na tabela
$sql = "UPDATE receitas SET
  descricao = :descricao,
  valor = :valor,
  data_mvto = :data_mvto,
  categoria_id = :categoria_id
WHERE id = :id";

$sql = $pdo->prepare($sql);
$sql->bindValue(":descricao", $descricao);
$sql->bindValue(":valor", $valor);
$sql->bindValue(":data_mvto", $data_mvto);
$sql->bindValue(":categoria_id", $categoria['id']);
$sql->bindValue(":id", $id);

$sql->execute();

header("Location: receitas.php");
exit;
