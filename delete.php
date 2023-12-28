<?php

require 'loader.php';

$userDao = new UserDao($db);
$colorDao = new ColorDao($db);

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (empty($_GET['id'])) {
        notifyAndRedir('danger', 'ID do usuário não foi enviado!', 'index.php');
    }

    try {
        $userDao->delete($userDao->getUserById($_GET['id']));
        notifyAndRedir('success', 'Usuário deletado com sucesso!', 'index.php');
    } catch ( Exception $e ) {
        notifyAndRedir('danger', $e->getMessage(), 'index.php');
    }

    

}