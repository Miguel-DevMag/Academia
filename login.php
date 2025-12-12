<?php
/**
 * login.php - Página de login com autenticação contra o banco de dados
 */

require_once 'auth_config.php';

// Se já está logado, redireciona para página principal
if (isLoggedIn()) {
    header("Location: index.php");
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
<?php require_once 'header.php'; ?>

<div class="max-w-md mx-auto login-box bg-white p-8 rounded-lg">
  <h1 class="text-2xl font-bold mb-4">🔒 Login</h1>
  <?php if (!empty($erro)): ?>
    <div class="error">❌ <?php echo htmlspecialchars($erro); ?></div>
  <?php endif; ?>
  <?php if (!empty($sucesso)): ?>
    <div class="success">✅ <?php echo htmlspecialchars($sucesso); ?></div>
  <?php endif; ?>

  <form method="POST" class="space-y-4">
    <div>
      <label for="usuario" class="block font-semibold">Usuário ou Email:</label>
      <input type="text" id="usuario" name="usuario" required autofocus class="w-full p-3 border rounded" />
    </div>
    <div>
      <label for="senha" class="block font-semibold">Senha:</label>
      <input type="password" id="senha" name="senha" required class="w-full p-3 border rounded" />
    </div>
    <div>
      <button type="submit" class="btn-login w-full">Entrar</button>
    </div>
  </form>

  <div class="links mt-4 text-center">
    <a href="register.php" class="mr-3">Criar Conta</a>
    <a href="esqueci_senha.php" class="mr-3">Esqueci Senha</a>
    <a href="index.php">← Voltar</a>
  </div>
</div>

<?php require_once 'footer.php'; ?>
