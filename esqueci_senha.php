<?php
include "conexao.php";

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $mensagem = "Um link de recuperação será enviado para o email informado.";
        // FUTURO: gerar token + enviar email
    } else {
        $mensagem = "Esse email não está cadastrado.";
    }
}
?>


<!DOCTYPE html>
<html class="dark" lang="pt-BR">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Recuperar Senha</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="css/login_styles.css">
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-gray-900 dark:text-white">

<div class="relative flex min-h-screen">

    <div class="flex flex-col justify-center items-center w-full p-10 max-w-md mx-auto">

        <h1 class="text-3xl font-bold mb-3">Recuperar Senha</h1>
        <p class="mb-5 text-gray-500 dark:text-gray-300">Digite seu email para enviar um link de redefinição.</p>

        <?php if ($mensagem): ?>
            <p class="text-primary font-bold mb-4"><?= $mensagem ?></p>
        <?php endif; ?>

        <form method="POST" class="w-full space-y-5">
            
            <label class="flex flex-col">
                <span>Email</span>
                <input type="email" name="email" required class="form-input h-12 px-4 rounded-lg">
            </label>

            <button class="w-full h-12 bg-primary text-white font-bold rounded-lg">
                Enviar link
            </button>
        </form>

        <p class="mt-5 text-center">
            <a href="login.php" class="text-primary font-bold">Voltar ao Login</a>
        </p>

    </div>

</div>
<?php if ($mensagem): ?>
  <p class="text-primary font-bold"><?= $mensagem ?></p>
<?php endif; ?>

</body>
</html>
