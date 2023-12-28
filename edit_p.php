<?php

require 'loader.php';

$userDao = new UserDao($db);
$colorDao = new ColorDao($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        $user_id = $_POST['uid'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $colors_ids = $_POST['colors'];

        $user = $userDao->getUserById((int) $user_id);
        $user->setName($name);
        $user->setEmail($email);

        $colors = [];

        foreach ($colors_ids as $color_id) {
            array_push($colors, $colorDao->getColorById($color_id));
        }

        $user->setColors($colors);

        $userDao->update($user);

        notifyAndRedir('success', 'Usuário editado com sucesso!', 'index.php');
    } catch (Exception $e) {
        notifyAndRedir('danger', $e->getMessage(), 'index.php');
    }

}