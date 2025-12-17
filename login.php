<?php
session_start();
// Se tiver o arquivo de conexão, descomente a linha abaixo:
// require_once 'db.php';

$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    // Seu código de processamento PHP aqui...
    if (empty($email) || empty($senha)) {
        $erro = "Por favor, preencha todos os campos.";
    } else {
        $erro = "Erro: Conexão com banco de dados não configurada."; 
    }
}
?>

<!DOCTYPE html>
<html class="dark" lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Criar Conta - Academia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <style>
        body { font-family: 'Lexend', sans-serif; }
        .bg-custom-dark { background-color: #120d0d; }
        .bg-card-dark { background-color: #1f1616; }
    </style>
</head>
<body class="bg-custom-dark text-white min-h-screen flex items-center justify-center p-4">

    <div class="flex flex-col md:flex-row w-full max-w-5xl bg-card-dark rounded-[2rem] overflow-hidden border border-white/10 shadow-2xl">
        
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <a href="index.html" class="flex items-center gap-2 text-sm opacity-60 hover:opacity-100 mb-8 transition-opacity">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Voltar para o início
            </a>

            <h1 class="text-4xl font-black mb-2">login</h1>
            <p class="text-gray-400 mb-8">Faça o login e fique atento as nossas novidades e promôções.</p>

            <?php if ($erro): ?>
                <div class="bg-red-500/10 border border-red-500/50 text-red-500 p-3 rounded-xl text-sm mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">error</span>
                    <?php echo $erro; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-4">
                <input type="text" name="nome" placeholder="Nome Completo" 
                    class="w-full bg-black/30 border border-white/10 rounded-xl px-4 py-4 focus:outline-none focus:border-[#ec1313] transition-colors">
                
                
                <input type="password" name="senha" placeholder="Senha" required
                    class="w-full bg-black/30 border border-white/10 rounded-xl px-4 py-4 focus:outline-none focus:border-[#ec1313] transition-colors">

                <button type="submit" 
                    class="w-full bg-[#ec1313] hover:bg-[#c91111] text-white font-bold py-4 rounded-xl transition-all shadow-lg flex items-center justify-center gap-2 mt-4">
                  logar
                </button>
            </form>

            <p class="mt-8 text-center text-sm opacity-60">
                não possui conta? <a href="criar_conta.html" class="text-[#ec1313] font-bold hover:underline">Entrar</a>
            </p>
        </div>

        <div class="hidden md:block w-1/2 relative">
            <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2070&auto=format&fit=crop" 
                 alt="Treino" 
                 class="absolute inset-0 w-full h-full object-cover">
            
            <div class="absolute inset-0 bg-gradient-to-t from-[#120d0d] via-transparent to-transparent p-12 flex flex-col justify-end">
                <h2 class="text-4xl font-black leading-tight mb-4">Junte-se ao time.</h2>
                <p class="text-gray-300">Comece sua jornada de transformação hoje mesmo com a melhor estrutura.</p>
            </div>
        </div>
    </div>

</body>
</html>