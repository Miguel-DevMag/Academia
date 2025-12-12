<?php
/**
 * auth_config.php - Configuração centralizada de autenticação
 * Incluir este arquivo em todas as páginas que requerem sessão
 */

session_start();

// Verifica se o usuário está logado
function isLoggedIn() {
    return isset($_SESSION['usuario_id']) && !empty($_SESSION['usuario_id']);
}

// Retorna o usuário atual
function getLoggedUser() {
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['usuario_id'],
            'nome' => $_SESSION['usuario_nome'],
            'email' => $_SESSION['usuario_email'],
            'usuario' => $_SESSION['usuario_username']
        ];
    }
    return null;
}

// Força login antes de acessar uma página
function requireLogin($redirect = 'login.php') {
    if (!isLoggedIn()) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        header("Location: " . $redirect);
        exit;
    }
}

// Conecta ao banco de dados
function getDbConnection() {
    $servidor = "localhost";
    $usuario_db = "root";
    $senha_db = "";
    $banco = "academia";
    
    $conn = new mysqli($servidor, $usuario_db, $senha_db, $banco);
    
    if ($conn->connect_error) {
        die("Erro ao conectar no banco de dados: " . $conn->connect_error);
    }
    
    $conn->set_charset('utf8mb4');
    return $conn;
}
?>
