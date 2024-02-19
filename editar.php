<?php
require "./config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"];
    $descricao = $_POST["descricao"];
    $valor = $_POST["valor"];
    $data_mvto = $_POST["data_mvto"];

    $sql = "UPDATE receitas SET descricao = :descricao, valor = :valor, data_mvto = :data_mvto WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":id", $id);
    $stmt->bindValue(":descricao", $descricao);
    $stmt->bindValue(":valor", $valor);
    $stmt->bindValue(":data_mvto", $data_mvto);
    $stmt->execute();

    header("Location: receitas.php");
    exit;
} else {
    header("Location: receitas.php");
    exit;
}
