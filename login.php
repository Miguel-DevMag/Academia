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
<html class="dark" lang="pt-BR">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Login da Academia</title>

  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
  <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
    rel="stylesheet" />

  <link rel="stylesheet" href="css/login_styles.css">

  <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            primary: "#ec1313",
            "background-light": "#ffffff",
            "background-dark": "#181111",
            "text-light": "#000000",
          },
          fontFamily: {
            display: ["Lexend", "sans-serif"]
          },
          borderRadius: {
            DEFAULT: "0.25rem",
            lg: "0.5rem",
            xl: "0.75rem",
            full: "9999px"
          }
        }
      }
    }
  </script>

</head>

<body class="bg-background-light dark:bg-background-dark font-display text-gray-900 dark:text-white">
  <div class="relative flex min-h-screen w-full flex-col overflow-x-hidden ">
    <div class="flex-grow">
      <div class="min-h-screen lg:grid lg:grid-cols-2">



        <!-- LEFT -->
        <div class="flex flex-col items-center justify-center p-6 sm:p-10">
          <div class="w-full max-w-md">

            <div id="accessibility-controls" class="flex items-center gap-4 pb-5">

              <button id="increase-font"
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden justify-center leading-normal rounded-lg  text-black dark:text-white text-sm font-bold border rounded-sm p-1 pr-3 pl-3 hover:bg-red-500">Aumentar</button>
              <button id="decrease-font"
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden justify-center leading-normal  rounded-lg  text-black dark:text-white text-sm font-bold border rounded-sm p-1 pr-3 pl-3 hover:bg-red-500">Diminuir</button>
              <button id="reset-font"
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden justify-center leading-normal rounded-lg  text-black dark:text-white text-sm font-bold border rounded-sm p-1 pr-3 pl-3 hover:bg-red-500 ">Padrão</button>

              <button id="toggle-contrast"
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden leading-normal justify-center rounded-lg  text-black dark:text-white text-sm font-bold border rounded-sm p-1 pr-3 pl-3 hover:bg-red-500 ">
                Contraste
              </button>

              <button id="tts-toggle"
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden leading-normal justify-center  rounded-lg  text-black dark:text-white text-sm font-bold border rounded-sm p-1 pr-3 pl-3  hover:bg-red-500">
                Ouvir
              </button>
            </div>

            <div class="mb-8 text-center">
              <h1 class="titli text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Acesse sua conta</h1>
              <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Bem-vindo de volta! Insira seus dados para
                continuar.</p>
            </div>

            <!-- FORMULÁRIO -->
            <form action="login.php" method="POST" class="space-y-6">

              <!-- EMAIL -->
              <div>
                <label class="flex flex-col flex-1">
                  <p class="text-sm font-medium pb-2 text-gray-700 dark:text-gray-300">Email ou usuário</p>
                  <input name="email" required
                    class="form-input flex w-full rounded-lg text-gray-900 dark:text-white border border-gray-300 dark:border-gray-700 bg-white/50 dark:bg-gray-800/50 h-12 px-4 placeholder-gray-400"
                    placeholder="Digite seu email" />
                </label>
              </div>

              <!-- SENHA -->
              <div>
                <label class="flex flex-col flex-1">
                  <p class="text-sm font-medium pb-2 text-gray-700 dark:text-gray-300">Senha</p>
                  <div class="flex w-full items-stretch rounded-lg ">
                    <input name="senha" required type="password"
                      class="form-input flex w-full outline-none rounded-l-lg border border-gray-300 dark:border-gray-700 bg-white/50 dark:bg-gray-800/50 h-12 px-4 placeholder-gray-400"
                      placeholder="Digite sua senha" />

                    <button type="button" id="toggleSenha" aria-label="Toggle password visibility"
                      class="text-gray-400 dark:text-gray-500 flex border border-gray-300 dark:border-gray-700 bg-white/50 dark:bg-gray-800/50 items-center justify-center px-3 rounded-r-lg hover:text-gray-600 dark:hover:text-gray-300">
                      <span class="material-symbols-outlined">visibility</span>
                    </button>
                  </div>
                </label>

                <div class="text-right mt-2">
                  <a class="text-sm font-medium text-primary hover:underline" href="esqueci_senha.php">Esqueci minha
                    senha</a>
                </div>
              </div>

              <!-- BOTÃO ENTRAR -->
              <div>
                <a href="index.html"
                  class="flex w-full items-center justify-center rounded-lg h-12 px-5 bg-primary text-white font-bold hover:bg-primary/90 focus:ring-2 focus:ring-offset-2 focus:ring-primary transition text-center no-underline">
                  Entrar
                </a>
              </div>

              <div class="mt-8 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                  Não tem uma conta?
                  <a class="font-bold text-primary hover:underline" href="criar_conta.php">Crie uma agora</a>
                </p>
              </div>

          </div>
        </div>

        <!-- RIGHT -->
        <div class="hidden lg:block relative">
          <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('https://img.freepik.com/fotos-premium/homem-de-aptidao-muscular-esporte-malhando-na-academia_174475-125.jpg'); ">
          </div>

          <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
        </div>

      </div>
    </div>
  </div>


</body>

<script>
  let fontSize = 100;

  function updateFont() {
    document.documentElement.style.fontSize = fontSize + "%";
  }

  document.getElementById("increase-font").onclick = () => {
    fontSize += 10;
    updateFont();
  };

  document.getElementById("decrease-font").onclick = () => {
    if (fontSize > 50) {
      fontSize -= 10;
      updateFont();
    }
  };

  document.getElementById("reset-font").onclick = () => {
    fontSize = 100;
    updateFont();
  };


  document.getElementById("toggle-contrast").onclick = () => {
    document.documentElement.classList.toggle("dark");
  };
</script>



<script>
  let ttsActive = false;
  let utterance = new SpeechSynthesisUtterance();

  document.getElementById("tts-toggle").onclick = () => {

    if (!ttsActive) {
      utterance.text = document.body.innerText;
      speechSynthesis.speak(utterance);
      ttsActive = true;
      document.getElementById("tts-toggle").innerText = "Parar";
    } else {
      speechSynthesis.cancel();
      ttsActive = false;
      document.getElementById("tts-toggle").innerText = "Ouvir";
    }
  };
</script>
<script>
  // BOTÃO DO MENU MOBILE
  const menuBtn = document.getElementById("menu-btn");
  const mobileMenu = document.getElementById("mobile-menu");

  menuBtn.onclick = () => {
    mobileMenu.classList.toggle("hidden");
  };

  // --------- ACESSIBILIDADE MOBILE --------- //

  // Fonte
  document.getElementById("increase-font-mobile").onclick = () => {
    fontSize += 10;
    updateFont();
  };

  document.getElementById("decrease-font-mobile").onclick = () => {
    if (fontSize > 50) {
      fontSize -= 10;
      updateFont();
    }
  };

  document.getElementById("reset-font-mobile").onclick = () => {
    fontSize = 100;
    updateFont();
  };

  // Contraste
  document.getElementById("toggle-contrast-mobile").onclick = () => {
    document.documentElement.classList.toggle("dark");
  };

  // Leitura em voz alta (mobile)
  document.getElementById("tts-toggle-mobile").onclick = () => {

    if (!ttsActive) {
      utterance.text = document.body.innerText;
      speechSynthesis.speak(utterance);
      ttsActive = true;
      document.getElementById("tts-toggle-mobile").innerText = "Parar";
    } else {
      speechSynthesis.cancel();
      ttsActive = false;
      document.getElementById("tts-toggle-mobile").innerText = "Ouvir";
    }

  };
</script>



</html>

</html>
<script src="theme-toggle.js"></script>