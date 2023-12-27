<?php

require_once 'connection.php';

$connection = new Connection();
$db_conn = $connection->getConnection();

// verificar se veio o formulário via post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // pegar os dados do formulário
    $id = $_POST['uid'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $colors = $_POST['colors'];

    $update_query = "UPDATE users SET name = :new_name, email = :new_email WHERE id = :id";
    $stmt = $db_conn->prepare($update_query);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':new_name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':new_email', $email, PDO::PARAM_STR);
    $result = $stmt->execute();

    // DELETAR CORES DO USUARIO
    $colors_delete_query = "DELETE FROM user_colors WHERE user_id = :id";
    $stmt = $db_conn->prepare($colors_delete_query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    foreach ($colors as $color) {
        $insert_into_user_colors = "INSERT INTO user_colors (user_id, color_id) VALUES (:user_id, :color_id)";
        $color_stmt = $db_conn->prepare($insert_into_user_colors);
        $color_stmt->bindValue("user_id", $id, PDO::PARAM_INT);
        $color_stmt->bindValue("color_id", $color, PDO::PARAM_INT);
        $color_stmt->execute();
    }



    header('Location: index.php?info=2');

} else {
    header('Location: index.php?error=3');
}