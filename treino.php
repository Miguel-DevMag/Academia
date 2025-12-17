<?php
// --- LÓGICA PHP (BACK-END) ---
function limpar($dado) {
    return htmlspecialchars($dado, ENT_QUOTES, 'UTF-8');
}

$treinosData = [
    'triceps' => [
        'titulo' => 'Treino de Tríceps',
        'subtitulo' => 'Foco em extensão e definição',
        'imagem' => 'https://static.strengthlevel.com/images/exercises/tricep-pushdown/tricep-pushdown-800.jpg',
        'tempo' => '40 min',
        'kcal' => '250 kcal',
        'exercicios' => [
            ['nome' => 'Tríceps Pulley', 'desc' => '3 séries · 12 repetições', 'obs' => 'Puxar a barra para baixo estendendo os braços.'],
            ['nome' => 'Tríceps Testa', 'desc' => '3 séries · 10 repetições', 'obs' => 'Deitado, flexionar os cotovelos levando a barra à testa.']
        ]
    ],
    'costas' => [
        'titulo' => 'Treino de Costas',
        'subtitulo' => 'Largura e densidade dorsal',
        'imagem' => 'https://static.strengthlevel.com/images/exercises/lat-pulldown/lat-pulldown-800.jpg',
        'tempo' => '50 min',
        'kcal' => '350 kcal',
        'exercicios' => [
            ['nome' => 'Puxada Frontal', 'desc' => '4 séries · 12 repetições', 'obs' => 'Puxar a barra em direção ao peito contraindo as escápulas.']
        ]
    ],
    'peito' => [
        'titulo' => 'Treino de Peito',
        'subtitulo' => 'Força e hipertrofia peitoral',
        'imagem' => 'https://static.strengthlevel.com/images/exercises/bench-press/bench-press-800.jpg',
        'tempo' => '45 min',
        'kcal' => '300 kcal',
        'exercicios' => [
            ['nome' => 'Supino Reto', 'desc' => '4 séries · 10 repetições', 'obs' => 'Empurrar a barra para cima a partir do peito.']
        ]
    ],
    'pernas' => [
        'titulo' => 'Treino de Pernas',
        'subtitulo' => 'Base sólida e queima calórica',
        'imagem' => 'https://static.strengthlevel.com/images/exercises/squat/squat-800.jpg',
        'tempo' => '60 min',
        'kcal' => '500 kcal',
        'exercicios' => [
            ['nome' => 'Agachamento Livre', 'desc' => '4 séries · 12 repetições', 'obs' => 'Flexionar os joelhos mantendo a coluna ereta.']
        ]
    ]
];

// Configurações de Acessibilidade
$tema_atual = $_GET['tema'] ?? 'padrao';
$tamanho_fonte = $_GET['fonte'] ?? 'medio';
$grupo_selecionado = $_GET['grupo'] ?? '';

function criarLink($params) {
    global $tema_atual, $tamanho_fonte, $grupo_selecionado;
    $novos = array_merge(['tema' => $tema_atual, 'fonte' => $tamanho_fonte, 'grupo' => $grupo_selecionado], $params);
    return "?" . http_build_query($novos);
}

// Texto para o Leitor de Tela
$texto_audio = $grupo_selecionado ? "Treino selecionado: " . $treinosData[$grupo_selecionado]['titulo'] : "Bem-vindo. Selecione um grupo muscular.";
?>

<!DOCTYPE html>
<html lang="pt-BR" class="<?php echo $tema_atual === 'alto-contraste' ? 'dark-mode' : ''; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treinos - Academia Acessível</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    
    <style>
        body { font-family: 'Lexend', sans-serif; transition: all 0.3s ease; }
        
        /* Tamanhos de Fonte */
        .fonte-pequeno { font-size: 14px; }
        .fonte-medio { font-size: 18px; }
        .fonte-grande { font-size: 22px; }

        /* Temas */
        .tema-padrao { background-color: #120d0d; color: white; }
        .tema-alto-contraste { background-color: black; color: #FFF000 !important; }
        .tema-alto-contraste .card-treino { border: 2px solid #FFF000; background: black; }
        .tema-alto-contraste .btn-acess { background: #FFF000; color: black; }

        .card-treino { background-color: #1f1616; border: 1px solid rgba(255,255,255,0.1); }
        .accent-red { background-color: #ec1313; }
    </style>
</head>

<body class="tema-<?php echo $tema_atual; ?> fonte-<?php echo $tamanho_fonte; ?> min-h-screen flex flex-col">
      <div class="bg-gray-100 dark:bg-[#1f1616] border-b border-black/10 dark:border-white/10 px-4 py-2 flex items-center justify-center gap-2 overflow-x-auto">
        <span class="text-[10px] font-bold opacity-50 uppercase tracking-wider mr-2 hidden sm:inline-block">Acessibilidade:</span>
        <button id="increase-font" class="px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-[10px] font-bold hover:bg-primary hover:text-white">AUMENTAR</button>
        <button id="decrease-font" class="px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-[10px] font-bold hover:bg-primary hover:text-white">DIMINUIR</button>
        <button id="reset-font" class="px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-[10px] font-bold hover:bg-primary hover:text-white">PADRÃO</button>
        <button id="toggle-contrast" class="px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-[10px] font-bold hover:bg-primary hover:text-white">CONTRASTE</button>
        <button id="tts-toggle" class="px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-[10px] font-bold hover:bg-primary hover:text-white">OUVIR</button>
    </div>




    <div class="w-full bg-white/5 border-b border-white/10 px-4 py-2 flex items-center justify-center gap-4 flex-wrap">
      

    <main class="max-w-4xl mx-auto w-full p-6">
        <header class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-4xl font-black">Treinos <span class="text-[#ec1313]">Acessíveis</span></h1>
                <p class="opacity-60">Escolha o grupo muscular para ver os exercícios detalhados.</p>
            </div>
            <a href="index.php" class="text-sm font-bold flex items-center gap-2 opacity-70 hover:opacity-100 transition-opacity">
                <span class="material-symbols-outlined">arrow_back</span> Voltar ao Início
            </a>
        </header>

        <div class="card-treino p-6 rounded-3xl mb-8">
            <form method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                <input type="hidden" name="tema" value="<?php echo $tema_atual; ?>">
                <input type="hidden" name="fonte" value="<?php echo $tamanho_fonte; ?>">
                
                <div class="flex-grow w-full">
                    <label class="block text-xs font-bold mb-2 opacity-50 uppercase tracking-widest">Grupo Muscular</label>
                    <select name="grupo" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 focus:border-[#ec1313] outline-none transition-colors">
                        <option value="">Selecione um treino...</option>
                        <?php foreach($treinosData as $key => $val): ?>
                            <option value="<?php echo $key; ?>" <?php echo $grupo_selecionado == $key ? 'selected' : ''; ?>>
                                <?php echo $val['titulo']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="bg-[#ec1313] hover:bg-[#c40f0f] px-8 py-3 rounded-xl font-black transition-all w-full md:w-auto">
                    BUSCAR
                </button>
            </form>
        </div>

        <?php if ($grupo_selecionado && isset($treinosData[$grupo_selecionado])): 
            $treino = $treinosData[$grupo_selecionado]; ?>
            
            <div class="animate-in fade-in duration-500">
                <div class="relative h-64 rounded-3xl overflow-hidden mb-8 border border-white/10">
                    <img src="<?php echo $treino['imagem']; ?>" class="w-full h-full object-cover opacity-60" alt="Demonstração do treino">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#1f1616] to-transparent"></div>
                    <div class="absolute bottom-6 left-6">
                        <span class="bg-[#ec1313] text-[10px] font-black px-3 py-1 rounded-full uppercase mb-2 inline-block">Ficha do Dia</span>
                        <h2 class="text-3xl font-black"><?php echo $treino['titulo']; ?></h2>
                        <div class="flex gap-4 mt-2 text-xs font-bold opacity-70">
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">schedule</span> <?php echo $treino['tempo']; ?></span>
                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">local_fire_department</span> <?php echo $treino['kcal']; ?></span>
                        </div>
                    </div>
                </div>

                <h3 class="text-xl font-black mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#ec1313]">list_alt</span> Exercícios do Treino
                </h3>

                <div class="space-y-4">
                    <?php foreach($treino['exercicios'] as $ex): ?>
                        <div class="card-treino p-6 rounded-2xl flex justify-between items-center group hover:border-[#ec1313]/50 transition-all">
                            <div>
                                <h4 class="font-bold text-lg"><?php echo $ex['nome']; ?></h4>
                                <p class="text-[#ec1313] text-sm font-bold"><?php echo $ex['desc']; ?></p>
                                <p class="text-sm opacity-50 mt-1"><?php echo $ex['obs']; ?></p>
                            </div>
                            <span class="material-symbols-outlined opacity-20 group-hover:opacity-100 transition-opacity">chevron_right</span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-8 text-center">
                    <a href="<?php echo criarLink(['grupo' => '']); ?>" class="text-sm font-bold opacity-50 hover:opacity-100">Limpar seleção</a>
                </div>
            </div>

        <?php else: ?>
            <div class="text-center py-20 opacity-30">
                <span class="material-symbols-outlined text-6xl mb-4">fitness_center</span>
                <p class="font-bold">Aguardando seleção de treino...</p>
            </div>
        <?php endif; ?>
    </main>

    <script>
        // Função de Áudio JS
        const textoParaLer = <?php echo json_encode($texto_audio); ?>;
        function lerTexto() {
            window.speechSynthesis.cancel();
            const utterance = new SpeechSynthesisUtterance(textoParaLer);
            utterance.lang = 'pt-BR';
            window.speechSynthesis.speak(utterance);
        }
    </script>
</body>
</html>