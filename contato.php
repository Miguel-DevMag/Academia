<?php
/**
 * contato.php - Página de contato com envio de mensagens para BD
 */

$mensagem_enviada = "";
$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'conexao.php';
    
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $assunto = trim($_POST['assunto'] ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');
    
    if (empty($nome) || empty($email) || empty($assunto) || empty($mensagem)) {
        $erro = "Todos os campos são obrigatórios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Email inválido.";
    } else {
        $stmt = $conn->prepare("INSERT INTO contatos (nome, email, mensagem, criado_em) VALUES (?, ?, ?, NOW())");
        if (!$stmt) {
            $erro = "Erro na preparação da query: " . $conn->error;
        } else {
            $mensagem_completa = "Assunto: " . $assunto . "\n\n" . $mensagem;
            $stmt->bind_param("sss", $nome, $email, $mensagem_completa);
            
            if ($stmt->execute()) {
                $mensagem_enviada = "✅ Mensagem enviada com sucesso! Entraremos em contato em breve.";
                // Limpar o formulário
                $_POST = [];
            } else {
                $erro = "Erro ao enviar mensagem: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>

<html class="dark" lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Contato da Academia</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&amp;display=swap" rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
    rel="stylesheet" />
  <style>
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
  </style>
  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "primary": "#ec1313",
            "background-light": "#f8f6f6",
            "background-dark": "#181111",
          },
          fontFamily: {
            "display": ["Lexend", "sans-serif"]
          },
          borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
        },
      },
    }
  </script>
</head>

<body class="font-display bg-background-light dark:bg-background-dark text-gray-800 dark:text-gray-200">
  <div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
    <div class="layout-container flex h-full grow flex-col">
      <header
        class="flex items-center justify-between whitespace-nowrap border-b border-solid border-gray-200 dark:border-b-[#392828] px-4 sm:px-10 py-4 w-full max-w-7xl mx-auto">
        <div class="flex items-center gap-4 text-gray-900 dark:text-white">
          <div class="size-6 text-primary">
          </div>
          <h2 class="text-xl font-bold leading-tight tracking-[-0.015em]">Academia</h2>
        </div>
        <div class="hidden md:flex flex-1 justify-end gap-8">
          <div class="flex items-center gap-9">
            <a class="text-sm font-medium leading-normal hover:text-primary transition-colors" href="index.html">Início</a>
            <a class="text-sm font-medium leading-normal hover:text-primary transition-colors" href="suplementos.html">Planos</a>
            <a class="text-sm font-medium leading-normal hover:text-primary transition-colors" href="treino.php">Aulas</a>
            <a class="text-primary text-sm font-bold leading-normal" href="#">Contato</a>
          </div>
        </div>
        <button
          class="md:hidden p-2 rounded-md text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800">
          <span class="material-symbols-outlined">menu</span>
        </button>
      </header>
      <main class="w-full max-w-7xl mx-auto px-4 sm:px-10 py-10">
        <div class="w-full">
          <div class="bg-cover bg-center flex flex-col justify-end overflow-hidden rounded-xl min-h-[300px] shadow-lg"
            data-alt="Interior de uma academia moderna com equipamentos de ginástica"
            style='background-image: linear-gradient(0deg, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0) 40%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuBBlD0XBUwmPgJREbqAAMInWILTx5nwaBFZLpTRdwzxQsWK11I8rogO-Z99IJo3b9YnI5ZdVwydgXZNtGb5zlPMf3mUb8ci36htoVjMdk7KqbQ6YowXRrtoasYv0vBPNzutmjFCMzAHfnv0oOYYDqSfCSlnw361i4M9GjIbBxlZsfAEdJL76rfbFsIyuVX612gMMxKTqvzNw0gMBoQiKGXs-x9ZVS7Uv7TpJN1w-CJclWDzLkwLYxpwmjd0F5QkA6Hq3oGRcXO3-a8");'>
            <div class="flex p-8">
              <p class="text-white tracking-light text-4xl md:text-5xl font-bold leading-tight">Entre em Contato Conosco
              </p>
            </div>
          </div>
        </div>
        <div class="mt-16">
          <div class="flex flex-wrap justify-between gap-4">
            <div class="flex flex-col gap-3 max-w-xl">
              <p class="text-gray-900 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Fale
                Conosco</p>
              <p class="text-gray-600 dark:text-[#b99d9d] text-base font-normal leading-normal">Estamos aqui para
                ajudar! Preencha o formulário abaixo ou utilize um de nossos canais de contato. Nossa equipe responderá
                o mais rápido possível.</p>
            </div>
          </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mt-12">
          <div class="flex flex-col">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
              <div class="col-span-1 flex items-start gap-4 p-4 rounded-lg bg-gray-100 dark:bg-black/20">
                <span class="material-symbols-outlined text-primary mt-1">location_on</span>
                <div>
                  <p class="text-gray-900 dark:text-white font-semibold">Endereço</p>
                  <p class="text-gray-600 dark:text-[#b99d9d] text-sm">Rua da Academia, 123</p>
                </div>
              </div>
              <div class="col-span-1 flex items-start gap-4 p-4 rounded-lg bg-gray-100 dark:bg-black/20">
                <span class="material-symbols-outlined text-primary mt-1">call</span>
                <div>
                  <p class="text-gray-900 dark:text-white font-semibold">Telefone</p>
                  <p class="text-gray-600 dark:text-[#b99d9d] text-sm">(11) 9999-9999</p>
                </div>
              </div>
              <div class="col-span-1 flex items-start gap-4 p-4 rounded-lg bg-gray-100 dark:bg-black/20">
                <span class="material-symbols-outlined text-primary mt-1">mail</span>
                <div>
                  <p class="text-gray-900 dark:text-white font-semibold">Email</p>
                  <p class="text-gray-600 dark:text-[#b99d9d] text-sm">contato@academia.com</p>
                </div>
              </div>
              <div class="col-span-1 flex items-start gap-4 p-4 rounded-lg bg-gray-100 dark:bg-black/20">
                <span class="material-symbols-outlined text-primary mt-1">schedule</span>
                <div>
                  <p class="text-gray-900 dark:text-white font-semibold">Horário</p>
                  <p class="text-gray-600 dark:text-[#b99d9d] text-sm">Seg-Dom 6:00 - 22:00</p>
                </div>
              </div>
            </div>
          </div>
          <div class="flex flex-col gap-6">
            <?php if (!empty($mensagem_enviada)): ?>
              <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; border: 1px solid #c3e6cb; font-weight: bold;">
                <?php echo $mensagem_enviada; ?>
              </div>
            <?php endif; ?>
            
            <?php if (!empty($erro)): ?>
              <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; border: 1px solid #f5c6cb; font-weight: bold;">
                <?php echo $erro; ?>
              </div>
            <?php endif; ?>

            <form method="POST" class="flex flex-col gap-4">
              <input class="w-full min-h-fit rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 px-3 py-2 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary"
                placeholder="Seu Nome" type="text" name="nome" required />
              <input class="w-full min-h-fit rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 px-3 py-2 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary"
                placeholder="Seu Email" type="email" name="email" required />
              <input class="w-full min-h-fit rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 px-3 py-2 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary"
                placeholder="Assunto" type="text" name="assunto" required />
              <textarea class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 px-3 py-2 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary min-h-32 resize-none"
                placeholder="Sua Mensagem" name="mensagem" required></textarea>
              <button type="submit"
                class="flex min-h-12 cursor-pointer items-center justify-center rounded-lg bg-primary px-6 py-3 text-white font-bold hover:bg-red-700 transition-colors">
                Enviar Mensagem
              </button>
            </form>
          </div>
        </div>
      </main>
      <footer
        class="w-full max-w-7xl mx-auto px-4 sm:px-10 py-8 mt-16 border-t border-gray-200 dark:border-b-[#392828]">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
          <div class="flex items-center gap-3">
            <div class="size-6 text-primary">
            </div>
            <p class="text-gray-900 dark:text-white font-bold">Academia</p>
          </div>
          <p class="text-gray-600 dark:text-[#b99d9d] text-sm">© 2025 Academia. Todos os direitos reservados.</p>
        </div>
      </footer>
    </div>
  </div>
</body>

</html>
<script src="theme-toggle.js"></script>
