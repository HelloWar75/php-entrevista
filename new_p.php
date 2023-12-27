<?php

require 'loader.php';

$userDao = new UserDao($db);
$colorDao = new ColorDao($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $colors_ids = $_POST['colors'];

    $user = new User($name, $email);
    
    $colors = [];

    foreach($colors_ids as $color_id) {
        array_push($colors, $colorDao->getColorById($color_id));
    }

    $user->setColors($colors);

    $userDao->insert($user);

    notifyAndRedir('success', 'Usuário adicionado com sucesso!', 'index.php');
}