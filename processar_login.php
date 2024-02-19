<?php
require "./config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["emailLogin"];
    $senha = $_POST["senhaLogin"];

    $sql = "SELECT id FROM usuarios WHERE email = :email AND senha = :senha";
    $query = $pdo->prepare($sql);
    $query->bindParam(':email', $email);
    $query->bindParam(':senha', $senha);

    // Executa a consulta no banco de dados
    $query->execute();
    $usuario = $query->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        // Credenciais corretas, define a variável de sessão e redireciona para a página principal
        session_start();
        $_SESSION['usuario_id'] = $usuario['id'];
        header("Location: perfil.php");
        exit();
    } else {
        // Credenciais incorretas, redireciona de volta para a página de login com mensagem de erro
        header("Location: login.php?erro=1");
        exit();
    }
} else {
    // Redireciona para a página de login se o formulário não foi enviado
    header("Location: login.php");
    exit();
}
