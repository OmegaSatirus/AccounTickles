<?php

$name = "hg5pss68_bntds_vermelho";
$host = "5ps.site";
$user = "hg5pss68_bntds_vermelho";
$pass = "$!-MpY&G)f*p";

try {
  $pdo = new PDO("mysql:host=$host;dbname=$name", $user, $pass);
} catch (PDOException $e) {
  echo "ERRO: " . $e->getMessage();
}