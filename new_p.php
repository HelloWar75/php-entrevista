<?php

require_once 'connection.php';

$connection = new Connection();
$db_conn = $connection->getConnection();

// verificar se veio o formulário via post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // pegar os dados do formulário
    $name = $_POST['name'];
    $email = $_POST['email'];
    $colors = $_POST['colors'];

    $insert_user_query = "INSERT INTO users (name, email) VALUES (:name, :email)";
    $stmt = $db_conn->prepare($insert_user_query);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $result = $stmt->execute();
    $user_id = $db_conn->lastInsertId();

    if ( $result ) {
        foreach ($colors as $color) {
            $insert_into_user_colors = "INSERT INTO user_colors (user_id, color_id) VALUES (:user_id, :color_id)";
            $color_stmt = $db_conn->prepare($insert_into_user_colors);
            $color_stmt->bindValue("user_id", $user_id, PDO::PARAM_INT);
            $color_stmt->bindValue("color_id", $color, PDO::PARAM_INT);
            $color_stmt->execute();
        }
    }


    header('Location: index.php?info=3');

} else {
    header('Location: index.php?error=4');
}