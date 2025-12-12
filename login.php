<?php
/**
 * login.php - Página de login com autenticação contra o banco de dados
 */

require_once 'auth_config.php';

// Se já está logado, redireciona para página principal
if (isLoggedIn()) {
    header("Location: index.html");
    exit;
}

$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $senha = $_POST['senha'] ?? '';
    
    if (empty($usuario) || empty($senha)) {
        $erro = "Por favor, preencha usuário e senha.";
    } else {
        $conn = getDbConnection();
        
        // Busca usuário por nome de usuário OU email
        $stmt = $conn->prepare("SELECT id, nome, email, usuario, senha_hash FROM users WHERE usuario = ? OR email = ?");
        $stmt->bind_param("ss", $usuario, $usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verifica senha com password_verify
            if (password_verify($senha, $user['senha_hash'])) {
                // Login bem-sucedido - cria sessão
                $_SESSION['usuario_id'] = $user['id'];
                $_SESSION['usuario_nome'] = $user['nome'];
                $_SESSION['usuario_email'] = $user['email'];
                $_SESSION['usuario_username'] = $user['usuario'];
                
                // Redireciona para a página que tentava acessar, ou para página principal
                $redirect = $_SESSION['redirect_after_login'] ?? 'index.html';
                unset($_SESSION['redirect_after_login']);
                
                header("Location: " . $redirect);
                exit;
            } else {
                $erro = "Senha incorreta.";
            }
        } else {
            $erro = "Usuário ou email não encontrado.";
        }
        
        $stmt->close();
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Academia</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { background: linear-gradient(135deg, #001f3f, #003366); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-box { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); width: 100%; max-width: 400px; }
        .login-box h1 { text-align: center; color: #333; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #555; font-weight: bold; }
        .form-group input { width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; box-sizing: border-box; }
        .form-group input:focus { outline: none; border-color: #ec1313; }
        .btn-login { width: 100%; padding: 12px; background: linear-gradient(135deg, #ec1313, #ff3300); color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; font-size: 1rem; }
        .btn-login:hover { background: linear-gradient(135deg, #ff3300, #ec1313); }
        .error { color: #ff3300; background: #ffe6e6; padding: 12px; border-radius: 5px; margin-bottom: 20px; }
        .success { color: #0056b3; background: #e6f2ff; padding: 12px; border-radius: 5px; margin-bottom: 20px; }
        .links { text-align: center; margin-top: 20px; }
        .links a { color: #0056b3; text-decoration: none; margin: 0 10px; }
        .links a:hover { text-decoration: underline; }
    </style>
    <script src="theme-toggle.js"></script>
</head>
<body>
    <div class="login-box">
        <h1>🔒 Login</h1>
        
        <?php if (!empty($erro)): ?>
            <div class="error">❌ <?php echo htmlspecialchars($erro); ?></div>
        <?php endif; ?>
        
        <?php if (!empty($sucesso)): ?>
            <div class="success">✅ <?php echo htmlspecialchars($sucesso); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="usuario">Usuário ou Email:</label>
                <input type="text" id="usuario" name="usuario" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            
            <button type="submit" class="btn-login">Entrar</button>
        </form>
        
        <div class="links">
            <a href="register.php">Criar Conta</a>
            <a href="esqueci_senha.html">Esqueci Senha</a>
            <a href="index.html">← Voltar</a>
        </div>
    </div>
</body>
</html>
