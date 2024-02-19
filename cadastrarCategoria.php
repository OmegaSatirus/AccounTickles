<?php
require "./config.php";

$descricao = $_GET["descricao_categoria"];

$sql = "INSERT INTO categoria (descricao) VALUES
        (:descricao)";

$sql = $pdo->prepare($sql);
$sql->bindValue(":descricao", $descricao);

$sql->execute();

header("Location: categoria.php");
exit;
