<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "academia";

// Tenta conectar sem selecionar o DB para criar se necessário
$conn = new mysqli($servidor, $usuario, $senha);
if ($conn->connect_error) {
    die("Erro na conexão com o servidor MySQL: " . $conn->connect_error);
}

// Cria o banco se não existir e define charset
$created = $conn->query("CREATE DATABASE IF NOT EXISTS `" . $conn->real_escape_string($banco) . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
if ($created === false) {
    die("Erro ao criar banco de dados: " . $conn->error);
}

$conn->select_db($banco);
$conn->set_charset('utf8mb4');

// Agora $conn está conectado ao DB "academia"
// Use este arquivo com include/require onde precisar da conexão
?>
