<?php
require "./config.php";

$id = $_GET["id"];

$sql = "DELETE FROM despesa WHERE id = :id";
$query = $pdo->prepare($sql);

$query->bindValue(":id", $id);
$query->execute();

header("Location: despesas.php");
exit;
?>
