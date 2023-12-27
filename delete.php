<?php

require 'connection.php';
$connection = new Connection();

// Verificar se $_GET está vazio caso esteja redirecionar e exibir erro
if (empty($_GET['id'])) {
    header('Location: index.php?error=1');
}

$id = $_GET['id'];

// Verifica se usuario existe no banco de dados
$users = $connection->query("SELECT * FROM users WHERE id = '$id'");

if ($users->fetchColumn() > 0) {
    $connection->exec("DELETE FROM users WHERE id = '$id'");
    $connection->exec("DELETE FROM user_colors WHERE user_id = '$id'");
    header('Location: index.php?action=1');
} else {
    header('Location: index.php?error=1');
}


