<?php

require 'loader.php';

$userDao = new UserDao($db);
$colorDao = new ColorDao($db);

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (empty($_GET['id'])) {
        header('Location: index.php?error=5');
    }

    $userDao->delete($userDao->getUserById($_GET['id']));

    notifyAndRedir('success', 'Usuário deletado com sucesso!', 'index.php');

}