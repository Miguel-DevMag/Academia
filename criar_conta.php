<?php
/**
 * criar_conta.php - Página de criação de conta (convertida de HTML para PHP)
 */

require_once 'auth_config.php';

// Se já está logado, redireciona
if (isLoggedIn()) {
    header("Location: index.html");
    exit;
}

$mensagem = "";
$erro = "";

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
            // Hash da senha
            $senha_hash = password_hash($senha, PASSWORD_BCRYPT);
            
            // Insere novo usuário
            $stmt = $conn->prepare("INSERT INTO users (nome, email, usuario, senha_hash) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nome, $email, $usuario, $senha_hash);
            
            if ($stmt->execute()) {
                $mensagem = "✅ Conta criada com sucesso! Você será redirecionado para login em 3 segundos...";
                // Redireciona após 3 segundos
                header("Refresh: 3; url=login.php");
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
<html class="dark" lang="pt-BR">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Criar Conta</title>

  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link rel="stylesheet" href="css/login_styles.css">
  <style>
    .error-box { background: #ffe6e6; color: #ff3300; padding: 12px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #ff3300; }
    .success-box { background: #e6f2ff; color: #0056b3; padding: 12px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #0056b3; }
  </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-gray-900 dark:text-white">

<div class="relative flex min-h-screen w-full flex-col overflow-hidden">
    <div class="flex-grow">
      <div class="min-h-screen lg:grid lg:grid-cols-2">

        <!-- Formulário -->
        <div class="flex flex-col items-center justify-center p-10">
          <div class="w-full max-w-md">
            <h1 class="text-3xl font-bold mb-4">Criar Conta</h1>

            <?php if (!empty($erro)): ?>
              <div class="error-box">❌ <?php echo htmlspecialchars($erro); ?></div>
            <?php endif; ?>

            <?php if (!empty($mensagem)): ?>
              <div class="success-box">✅ <?php echo htmlspecialchars($mensagem); ?></div>
            <?php endif; ?>

            <?php if (empty($mensagem)): ?>
            <form method="POST" class="space-y-5">
              
              <label class="flex flex-col">
                <span class="mb-1 font-medium">Nome Completo</span>
                <input name="nome" required class="form-input rounded-lg h-12 px-4">
              </label>

              <label class="flex flex-col">
                <span class="mb-1 font-medium">Email</span>
                <input name="email" required type="email" class="form-input rounded-lg h-12 px-4">
              </label>

              <label class="flex flex-col">
                <span class="mb-1 font-medium">Usuário</span>
                <input name="usuario" required class="form-input rounded-lg h-12 px-4" minlength="3">
              </label>

              <label class="flex flex-col">
                <span class="mb-1 font-medium">Senha</span>
                <input name="senha" required type="password" class="form-input rounded-lg h-12 px-4" minlength="6">
              </label>

              <label class="flex flex-col">
                <span class="mb-1 font-medium">Confirmar Senha</span>
                <input name="senha_conf" required type="password" class="form-input rounded-lg h-12 px-4" minlength="6">
              </label>

              <button type="submit" class="w-full h-12 bg-primary text-white rounded-lg font-bold">
                Criar Conta
              </button>

            </form>
            <?php endif; ?>

            <p class="mt-4 text-center">
                Já possui conta?
                <a href="login.php" class="text-primary font-bold">Entrar</a>
            </p>
          </div>
        </div>

        <!-- Imagem -->
        <div class="hidden lg:block relative">
          <div class="absolute inset-0 bg-cover bg-center"
               style="background-image: url('https://img.freepik.com/fotos-premium/homem-de-aptidao-muscular-esporte-malhando-na-academia_174475-125.jpg');"></div>
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
        </div>

      </div>
    </div>
</div>

</body>
</html>
<script src="theme-toggle.js"></script>
