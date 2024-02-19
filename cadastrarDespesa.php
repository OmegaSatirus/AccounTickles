<?php
require "./config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $descricao = $_POST["descricao"];
    $valor = $_POST["valor"];
    $data_mvto = $_POST["data_mvto"];
    $status_pago = $_POST["status_pago"];
    $descricao_categoria = $_POST["descricao_categoria"];

    try {
        $pdo->beginTransaction();

        // Verificar se a categoria existe e obter o ID
        $sqlCatId = "SELECT id FROM categoria WHERE descricao = :descricao_categoria LIMIT 1";
        $queryCatId = $pdo->prepare($sqlCatId);
        $queryCatId->bindValue(":descricao_categoria", $descricao_categoria);
        $queryCatId->execute();

        $categoria = $queryCatId->fetch(PDO::FETCH_ASSOC);

        if ($categoria) {
            // Usar o ID da categoria na inserção
            $sql = "INSERT INTO despesa (descricao, valor, data_mvto, status_pago, id_categoria) VALUES
                    (:descricao, :valor, :data_mvto, :status_pago, :id_categoria)";
            $query = $pdo->prepare($sql);
            $query->bindValue(":descricao", $descricao);
            $query->bindValue(":valor", $valor);
            $query->bindValue(":data_mvto", $data_mvto);
            $query->bindValue(":status_pago", $status_pago);
            $query->bindValue(":id_categoria", $categoria['id']);
            $query->execute();

            $pdo->commit();

            header("Location: despesas.php");
            exit;
        } else {
            // Categoria não encontrada, você pode tratar isso de acordo com suas necessidades
            echo "Categoria não encontrada!";
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Erro: " . $e->getMessage());
    }
} else {
    // Se não for um pedido POST, redirecione para a página de despesas
    header("Location: despesas.php");
    exit;
}
?>
