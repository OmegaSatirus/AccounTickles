<?php
require "./config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nomeRegistro"];
    $email = $_POST["emailRegistro"];
    $senha = $_POST["senhaRegistro"];
    $capital = $_POST["capitalRegistro"];

    $sql = "INSERT INTO usuarios (nome, email, senha, capital) VALUES (:nome, :email, :senha, :capital)";
    $query = $pdo->prepare($sql);
    $query->bindParam(':nome', $nome);
    $query->bindParam(':email', $email);
    $query->bindParam(':senha', $senha);
    $query->bindParam(':capital', $capital);

    // Executa a inserção no banco de dados
    $query->execute();

    // Redireciona para a página de login ou outra página desejada
    header("Location: login.php");
    exit();
} else {
    // Redireciona para a página de registro se o formulário não foi enviado
    header("Location: registro.php");
    exit();
}
