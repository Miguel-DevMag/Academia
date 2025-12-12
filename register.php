<?php
/**
 * register.php - Página de registro/criação de conta
 */

require_once 'auth_config.php';

// Se já está logado, redireciona
if (isLoggedIn()) {
    header("Location: index.html");
    exit;
}

$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $usuario = trim($_POST['usuario'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $senha_conf = $_POST['senha_conf'] ?? '';
    
    // Validações
    if (empty($nome) || empty($email) || empty($usuario) || empty($senha)) {
        $erro = "Por favor, preencha todos os campos.";
    } elseif (strlen($usuario) < 3) {
        $erro = "O usuário deve ter pelo menos 3 caracteres.";
    } elseif (strlen($senha) < 6) {
        $erro = "A senha deve ter pelo menos 6 caracteres.";
    } elseif ($senha !== $senha_conf) {
        $erro = "As senhas não conferem.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Email inválido.";
    } else {
        $conn = getDbConnection();
        
        // Verifica se usuário ou email já existem
        $stmt = $conn->prepare("SELECT id FROM users WHERE usuario = ? OR email = ?");
        $stmt->bind_param("ss", $usuario, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $erro = "Usuário ou email já existe.";
        } else {
            // Hash da senha com password_hash (recomendado)
            $senha_hash = password_hash($senha, PASSWORD_BCRYPT);
            
            // Insere novo usuário
            $stmt = $conn->prepare("INSERT INTO users (nome, email, usuario, senha_hash) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nome, $email, $usuario, $senha_hash);
            
            if ($stmt->execute()) {
                $sucesso = "✅ Conta criada com sucesso! <a href='login.php' style='color: #0056b3; font-weight: bold;'>Faça login aqui</a>";
            } else {
                $erro = "Erro ao criar conta. Tente novamente.";
            }
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
    <title>Criar Conta - Academia</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { background: linear-gradient(135deg, #001f3f, #003366); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .register-box { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); width: 100%; max-width: 450px; }
        .register-box h1 { text-align: center; color: #333; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #555; font-weight: bold; }
        .form-group input { width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; box-sizing: border-box; }
        .form-group input:focus { outline: none; border-color: #ec1313; }
        .btn-register { width: 100%; padding: 12px; background: linear-gradient(135deg, #ec1313, #ff3300); color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; font-size: 1rem; }
        .btn-register:hover { background: linear-gradient(135deg, #ff3300, #ec1313); }
        .error { color: #ff3300; background: #ffe6e6; padding: 12px; border-radius: 5px; margin-bottom: 20px; }
        .success { color: #0056b3; background: #e6f2ff; padding: 12px; border-radius: 5px; margin-bottom: 20px; }
        .links { text-align: center; margin-top: 20px; }
        .links a { color: #0056b3; text-decoration: none; margin: 0 10px; }
        .links a:hover { text-decoration: underline; }
    </style>
    <script src="theme-toggle.js"></script>
</head>
<body>
    <div class="register-box">
        <h1>📝 Criar Conta</h1>
        
        <?php if (!empty($erro)): ?>
            <div class="error">❌ <?php echo htmlspecialchars($erro); ?></div>
        <?php endif; ?>
        
        <?php if (!empty($sucesso)): ?>
            <div class="success"><?php echo $sucesso; ?></div>
        <?php endif; ?>
        
        <?php if (empty($sucesso)): ?>
        <form method="POST">
            <div class="form-group">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="usuario">Nome de Usuário:</label>
                <input type="text" id="usuario" name="usuario" required minlength="3">
            </div>
            
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required minlength="6">
            </div>
            
            <div class="form-group">
                <label for="senha_conf">Confirmar Senha:</label>
                <input type="password" id="senha_conf" name="senha_conf" required minlength="6">
            </div>
            
            <button type="submit" class="btn-register">Criar Conta</button>
        </form>
        <?php endif; ?>
        
        <div class="links">
            <a href="login.php">Já tem conta? Login</a>
            <a href="index.html">← Voltar</a>
        </div>
    </div>
</body>
</html>
