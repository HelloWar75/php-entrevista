<?php

session_start();

require_once 'connection.php';
$conn = new Connection();
$db = $conn->getConnection();

// Carregar e incluir todas arquivos php da pasta helpers
foreach (glob("helpers/*.php") as $filename) {
    require_once($filename);
}

// Carregar e incluir todas arquivos php da pasta models
foreach (glob("models/*.php") as $filename) {
    require_once($filename);
}

// Carregar e incluir todas arquivos php da pasta dao
foreach (glob("dao/*.php") as $filename) {
    require_once($filename);
}