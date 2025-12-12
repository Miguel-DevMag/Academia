<?php
/**
 * logout.php - Faz logout do usuário (destroi a sessão)
 */

require_once 'auth_config.php';

// Destruir a sessão
session_unset();
session_destroy();

// Redireciona para página inicial
header("Location: index.html");
exit;
?>
