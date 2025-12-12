<!DOCTYPE html>
<html class="dark" lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Alerta: Anabolizantes</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <style>
        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24
        }
    </style>

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

<body class="font-display bg-white text-black dark:bg-background-dark dark:text-white flex flex-col min-h-screen">

    <!-- BARRA DE ACESSIBILIDADE -->
    <div class="bg-gray-100 dark:bg-[#2a1f1f] border-b border-black/10 dark:border-white/10 px-4 py-2 flex items-center justify-center md:justify-end gap-3 overflow-x-auto whitespace-nowrap">
        <span class="text-xs font-bold opacity-50 uppercase tracking-wider mr-2 hidden sm:inline-block">Acessibilidade:</span>
        <button id="increase-font" class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded text-xs font-bold hover:bg-primary hover:text-white transition-colors">Aumentar</button>
        <button id="decrease-font" class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded text-xs font-bold hover:bg-primary hover:text-white transition-colors">Diminuir</button>
        <button id="reset-font" class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded text-xs font-bold hover:bg-primary hover:text-white transition-colors">Padrão</button>
        <button id="toggle-contrast" class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded text-xs font-bold hover:bg-primary hover:text-white transition-colors">Contraste</button>
        <button id="tts-toggle" class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded text-xs font-bold hover:bg-primary hover:text-white transition-colors">Ouvir</button>
    </div>

    <div class="relative flex w-full flex-col bg-background-light dark:bg-background-dark group/design-root overflow-x-hidden grow">
        <div class="layout-container flex h-full grow flex-col">
            <div class="px-4 md:px-10 lg:px-20 xl:px-40 flex flex-1 justify-center py-5">
                <div class="layout-content-container flex flex-col w-full max-w-[960px] flex-1">

                    <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-black dark:border-[#392828] px-4 py-4 mb-8">
                        <div class="flex items-center gap-4">
                            <a href="index.html" class="text-black dark:text-white hover:text-primary transition-colors">
                                <span class="material-symbols-outlined">arrow_back</span>
                            </a>
                            <h2 class="text-black dark:text-white text-xl font-bold">Informações</h2>
                        </div>
                    </header>

                    <main class="flex flex-col items-center gap-8">
                        
                        <!-- Cabeçalho da Seção -->
                        <div class="text-center space-y-4 animate-fade-in">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-primary/10 mb-2">
                                <span class="material-symbols-outlined text-primary text-5xl">warning</span>
                            </div>
                            <h1 class="text-3xl font-bold text-primary">Alerta sobre Anabolizantes</h1>
                            <p class="text-lg text-black/70 dark:text-white/70 max-w-xl mx-auto">
                                Informação é a melhor prevenção. Selecione uma substância abaixo para entender os riscos associados à saúde.
                            </p>
                        </div>

                        <!-- Área Interativa -->
                        <div class="w-full max-w-lg p-6 border border-black/10 dark:border-[#392828] rounded-xl bg-white/50 dark:bg-[#271c1c] shadow-sm">
                            
                            <label for="substancia" class="block text-sm font-bold text-black dark:text-white mb-2">Selecione para saber os riscos:</label>
                            
                            <div class="relative">
                                <select id="substancia" class="w-full rounded-lg bg-white dark:bg-[#181111] border border-gray-300 dark:border-[#543b3b] text-black dark:text-white focus:ring-primary focus:border-primary p-3 pr-10 appearance-none cursor-pointer shadow-sm transition-all hover:border-primary">
                                    <option value="">-- Selecione uma opção --</option>
                                    <option value="deca">Deca-Durabolin</option>
                                    <option value="dura">Durateston</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-black dark:text-white">
                                    <span class="material-symbols-outlined">expand_more</span>
                                </div>
                            </div>

                            <!-- Card de Resultado (Invisível inicialmente) -->
                            <div id="result-card" class="hidden mt-6 pt-6 border-t border-black/10 dark:border-white/10">
                                <div class="flex items-start gap-4">
                                    <span class="material-symbols-outlined text-primary text-3xl mt-1">info</span>
                                    <div>
                                        <h3 id="result-title" class="text-xl font-bold text-black dark:text-white mb-2">Título</h3>
                                        <p class="text-sm font-bold text-primary uppercase tracking-wider mb-1">Principais Riscos:</p>
                                        <p id="result-desc" class="text-black/80 dark:text-white/80 leading-relaxed">Descrição do risco.</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </main>

                    <footer class="border-t border-black dark:border-[#392828] px-4 py-8 mt-auto">
                        <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                            <h2 class="text-black dark:text-white font-bold">Academia</h2>
                            <div class="flex items-center gap-6 text-black dark:text-white/80 text-sm">
                                <a class="hover:text-primary" href="#">Termos</a>
                                <a class="hover:text-primary" href="#">Privacidade</a>
                                <a class="hover:text-primary" href="contato.php">Contato</a>
                            </div>
                            <div class="text-sm text-black dark:text-white/60">
                                © 2025 Academia. Todos os direitos reservados.
                            </div>
                        </div>
                    </footer>

                </div>
            </div>
        </div>
    </div>

    <script>
        // --- DADOS (Substituindo o Array PHP) ---
        const infoData = {
            'deca': {
                nome: "Deca-Durabolin",
                risco: "Alta retenção líquida, acne severa e risco cardíaco elevado."
            },
            'dura': {
                nome: "Durateston",
                risco: "Alterações hormonais agressivas, calvície, ginecomastia e agressividade."
            }
        };

        // --- ELEMENTOS DOM ---
        const select = document.getElementById('substancia');
        const resultCard = document.getElementById('result-card');
        const resultTitle = document.getElementById('result-title');
        const resultDesc = document.getElementById('result-desc');

        // Variável global para o texto do TTS (começa com o padrão)
        let ttsTextContent = "Alerta sobre Anabolizantes. Informação é a melhor prevenção. Selecione uma substância para saber os riscos.";

        // --- LÓGICA DE INTERAÇÃO ---
        select.addEventListener('change', (e) => {
            const valor = e.target.value;
            const dados = infoData[valor];

            if (dados) {
                // Atualiza o card
                resultTitle.innerText = dados.nome;
                resultDesc.innerText = dados.risco;
                
                // Mostra o card com animação simples
                resultCard.classList.remove('hidden');
                resultCard.classList.add('animate-fade-in');

                // Atualiza o texto que será lido pelo botão "Ouvir"
                ttsTextContent = `Você selecionou ${dados.nome}. Os principais riscos são: ${dados.risco}`;
            } else {
                // Esconde se selecionar a opção padrão
                resultCard.classList.add('hidden');
                ttsTextContent = "Alerta sobre Anabolizantes. Informação é a melhor prevenção. Selecione uma substância para saber os riscos.";
            }
        });

        // --- SCRIPTS DE ACESSIBILIDADE (Padrão do Projeto) ---
        let fontSize = 100;
        function updateFont() { document.documentElement.style.fontSize = fontSize + "%"; }
        
        document.getElementById("increase-font").onclick = () => { fontSize += 10; updateFont(); };
        document.getElementById("decrease-font").onclick = () => { if (fontSize > 50) { fontSize -= 10; updateFont(); } };
        document.getElementById("reset-font").onclick = () => { fontSize = 100; updateFont(); };
        document.getElementById("toggle-contrast").onclick = () => { document.documentElement.classList.toggle("dark"); };
        
        // TTS (Text-to-Speech) Integrado com a seleção
        let ttsActive = false;
        let utterance = new SpeechSynthesisUtterance();
        
        document.getElementById("tts-toggle").onclick = () => {
            if (!ttsActive) {
                // Usa a variável atualizada dinamicamente
                utterance.text = ttsTextContent;
                speechSynthesis.speak(utterance);
                ttsActive = true;
                document.getElementById("tts-toggle").innerText = "Parar";
            } else {
                speechSynthesis.cancel();
                ttsActive = false;
                document.getElementById("tts-toggle").innerText = "Ouvir";
            }
        };

        // Reseta o botão de ouvir quando a fala termina naturalmente
        utterance.onend = () => {
            ttsActive = false;
            document.getElementById("tts-toggle").innerText = "Ouvir";
        };
    </script>
    <script src="theme-toggle.js"></script>
</body>
</html>