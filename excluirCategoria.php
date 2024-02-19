<?php
require "./config.php";

$id = $_GET["id"];
$msg = "Não é possivel excluir uma categoria que está em uso!";

// Verificar se a categoria está presente na tabela 'receitas'
$sqlReceitas = "SELECT COUNT(*) AS count FROM receitas WHERE categoria_id = :id";
$stmtReceitas = $pdo->prepare($sqlReceitas);
$stmtReceitas->bindValue(":id", $id);
$stmtReceitas->execute();
$resultReceitas = $stmtReceitas->fetch(PDO::FETCH_ASSOC);

// Verificar se a categoria está presente na tabela 'despesas'
// $sqlDespesas = "SELECT COUNT(*) AS count FROM despesas WHERE categoria_id = :id";
// $stmtDespesas = $pdo->prepare($sqlDespesas);
// $stmtDespesas->bindValue(":id", $id);
// $stmtDespesas->execute();
// $resultDespesas = $stmtDespesas->fetch(PDO::FETCH_ASSOC);

// Se a categoria estiver presente em alguma das tabelas, redirecionar para a página e exibir uma mensagem
if ($resultReceitas['count'] > 0 || $resultDespesas['count'] > 0) {
    echo $msg;
} else {
    // Se a categoria não estiver presente em nenhuma tabela, prosseguir com a exclusão
    $sqlExcluirCategoria = "DELETE FROM categoria WHERE id = :id";
    $stmtExcluirCategoria = $pdo->prepare($sqlExcluirCategoria);
    $stmtExcluirCategoria->bindValue(":id", $id);
    $stmtExcluirCategoria->execute();

    header("Location: Categoria.php");
    exit;
}
?>
