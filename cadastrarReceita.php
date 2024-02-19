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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $descricao = $_POST["descricao"];
        $valor = $_POST["valor"];
        $data_mvto = $_POST["data_mvto"];
        $descricao_categoria = $_POST["descricao_categoria"];

        try {
                $pdo->beginTransaction();

                // Obter o ID da categoria com base na descrição selecionada
                $sqlCatId = "SELECT id FROM categoria WHERE descricao = :descricao_categoria";
                $queryCatId = $pdo->prepare($sqlCatId);
                $queryCatId->bindValue(":descricao_categoria", $descricao_categoria);
                $queryCatId->execute();
                $categoria = $queryCatId->fetch(PDO::FETCH_ASSOC);

                // Atualiza o capital do usuário no banco de dados
                $sqlAtualizarCapital = "UPDATE usuarios SET capital = capital + :valor WHERE id = :usuarioId";
                $queryAtualizarCapital = $pdo->prepare($sqlAtualizarCapital);
                $queryAtualizarCapital->bindParam(':valor', $valor);
                $queryAtualizarCapital->bindParam(':usuarioId', $usuarioId);
                $queryAtualizarCapital->execute();

                // Usar o ID da categoria na inserção
                $sqlInserirReceita = "INSERT INTO receitas (descricao, valor, data_mvto, categoria_id, usuario_id) VALUES
            (:descricao, :valor, :data_mvto, :categoria_id, :usuarioId)";
                $sqlInserirReceita = $pdo->prepare($sqlInserirReceita);
                $sqlInserirReceita->bindValue(":descricao", $descricao);
                $sqlInserirReceita->bindValue(":valor", $valor);
                $sqlInserirReceita->bindValue(":data_mvto", $data_mvto);
                $sqlInserirReceita->bindValue(":categoria_id", $categoria['id']);
                $sqlInserirReceita->bindValue(":usuarioId", $usuarioId);
                $sqlInserirReceita->execute();

                $pdo->commit();

                header("Location: receitas.php");
                exit;
        } catch (PDOException $e) {
                $pdo->rollBack();
                die("Erro: " . $e->getMessage());
        }
} else {
        // Se não for um pedido POST, redirecione para a página de receitas
        header("Location: receitas.php");
        exit;
}
