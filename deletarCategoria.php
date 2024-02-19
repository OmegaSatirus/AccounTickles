<?php
    require "./config.php";

    $id = $_GET["id"];

    $sql = "DELETE FROM categoria WHERE id = :id";
    $sql = $pdo->prepare($sql);

    $sql->bindValue(":id", $id);
    $sql->execute();

    header("Location: Categoria.php");
    exit;
