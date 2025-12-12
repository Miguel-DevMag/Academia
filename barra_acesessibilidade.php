<?php
// --- LÓGICA PHP (BACK-END) ---

// 1. Dados dos Vídeos
$videosData = [
    'video1' => [
        'titulo' => "Treino Adaptado de Musculação",
        'desc' => "Vídeo mostrando como um treino de musculação pode ser adaptado para diferentes necessidades.",
        'src' => "videos/video1.mp4"
    ],
    'video2' => [
        'titulo' => "Aula de Dança Inclusiva",
        'desc' => "Vídeo de uma aula de dança inclusiva, mostrando movimentos adaptados e ritmo.",
        'src' => "videos/video2.mp4"
    ],
    'video3' => [
        'titulo' => "Artes Marciais Adaptadas",
        'desc' => "Vídeo de artes marciais adaptadas, explicando técnicas seguras e defesa pessoal.",
        'src' => "videos/video3.mp4"
    ]
];

// 2. Captura configurações da URL
$video_escolhido = isset($_GET['video']) ? $_GET['video'] : '';
$tema_atual = isset($_GET['tema']) ? $_GET['tema'] : 'padrao';
$tamanho_fonte = isset($_GET['fonte']) ? $_GET['fonte'] : 'medio';

// 3. Função para manter a URL organizada
function criarLink($params) {
    global $video_escolhido, $tema_atual, $tamanho_fonte;
    $novos = array_merge([
        'video' => $video_escolhido,
        'tema' => $tema_atual,
        'fonte' => $tamanho_fonte
    ], $params);
    return "?" . http_build_query($novos);
}

// 4. Preparação do Texto para Áudio
$texto_audio = "Bem-vindo ao Accessibility Fitness. Academia acessível para pessoas com deficiência visual. " .
               "Nosso site oferece conteúdo sobre treinos, suplementos e saúde. " .
               "Use a navegação abaixo para escolher vídeos de treino adaptado, dança inclusiva ou artes marciais.";

if ($video_escolhido && isset($videosData[$video_escolhido])) {
    $texto_audio = "Você selecionou o vídeo: " . $videosData[$video_escolhido]['titulo'] . ". " . 
                   "Descrição: " . $videosData[$video_escolhido]['desc'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Accessibility Fitness</title>
  <link rel="stylesheet" href="style.css">

  <style>
    /* --- CONFIGURAÇÕES GERAIS --- */
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; margin: 0; background-color: #050a14; color: #333; }
    
    /* Tamanhos de Fonte */
    body.fonte-pequeno { font-size: 14px; }
    body.fonte-medio   { font-size: 18px; }
    body.fonte-grande  { font-size: 24px; }

    /* Container */
    .container { max-width: 800px; margin: 0 auto; padding: 20px; background: #0b162a; box-shadow: 0 0 20px rgba(0,0,0,0.05); }
    .titulo-destaque { color: #0056b3; }
    
    /* --- ESTILOS DOS BOTÕES (Geral) --- */
    .btn-moderno {
        display: inline-block; padding: 10px 18px; margin: 5px 2px; border-radius: 50px;
        text-decoration: none; font-weight: 600; border: none; cursor: pointer;
        transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center;
    }
    .btn-moderno:active { transform: translateY(2px); box-shadow: 0 1px 2px rgba(0,0,0,0.1); }

    /* Botões da Barra Superior */
    .btn-secundario { background-color: #f8f9fa; color: #0056b3; border: 2px solid #e9ecef; }
    .btn-secundario:hover { background-color: #0056b3; color: white; border-color: #0056b3; transform: translateY(-2px); }
    .btn-perigo { background-color: #fff0f0; color: #dc3545; border: 2px solid #f5c6cb; }
    .btn-perigo:hover { background-color: #dc3545; color: white; }

    /* Botão Principal (Visualizar Vídeo) */
    .btn-primario {
        background: linear-gradient(135deg, #ffae00, #ff7b00); color: white; font-size: 1.1em;
        padding: 12px 25px; text-transform: uppercase; letter-spacing: 0.5px;
        box-shadow: 0 5px 15px rgba(255, 123, 0, 0.3); width: 100%; max-width: 300px;
    }
    .btn-primario:hover {
        background: linear-gradient(135deg, #ffc400, #ff9100);
        box-shadow: 0 8px 20px rgba(255, 123, 0, 0.4); transform: translateY(-3px);
    }

    /* --- NOVO ESTILO PARA OS BOTÕES DO RODAPÉ (AZUL ESCURO SÓLIDO) --- */
    .nav-btn-redondo {
        display: inline-block;
        text-decoration: none;
        padding: 10px 24px;
        
        /* DEFININDO A COR AZUL ESCURO SÓLIDO */
        background-color: #004a99; 
        color: white !important;    /* Texto branco */
        border: 2px solid transparent; /* Borda transparente para manter o tamanho no hover */
        
        border-radius: 30px;
        margin: 5px 8px;
        transition: all 0.3s ease;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Sombra suave */
    }

    /* Efeito ao passar o mouse: Fica branco com borda azul */
    .nav-btn-redondo:hover {
        background-color: white;
        color: #004a99 !important;
        border-color: #004a99;
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }
    /* ----------------------------------------------------------- */


    /* Select Input */
    #videoSelect { padding: 10px; border-radius: 8px; border: 2px solid #ddd; font-size: 1rem; background-color: white; margin-bottom: 10px; width: 100%; max-width: 300px; }

    /* Barra de Acessibilidade */
    #barra-acessibilidade { padding: 15px; background: #0b162a; border-bottom: 1px solid #eee; text-align: center; position: fixed; top: 0; z-index: 100; box-shadow: 0 2px 10px rgba(0,0,0,0.05);width: 100%; }

    /* --- TEMA DE ALTO CONTRASTE --- */
    body.tema-alto-contraste { background-color: black !important; color: yellow !important; }
    body.tema-alto-contraste .container { background-color: #000; box-shadow: none; border: 1px solid yellow; }
    body.tema-alto-contraste .titulo-destaque { color: #FFD700 !important; }
    body.tema-alto-contraste a { color: #00FF00 !important; } /* Links verdes no alto contraste */
    body.tema-alto-contraste hr { border-color: yellow; }
    body.tema-alto-contraste #barra-acessibilidade { background: #000; border-bottom: 2px solid yellow; }
    
    /* Ajuste dos botões no alto contraste */
    body.tema-alto-contraste .btn-moderno,
    body.tema-alto-contraste .nav-btn-redondo { /* Adicionado nav-btn-redondo aqui */
        background: black !important; color: yellow !important; border: 2px solid yellow !important; box-shadow: none !important; background-image: none !important; 
    }
    body.tema-alto-contraste .btn-moderno:hover,
    body.tema-alto-contraste .nav-btn-redondo:hover {
        background: yellow !important; color: black !important; 
    }
    body.tema-alto-contraste #videoSelect { background: black; color: yellow; border: 2px solid yellow; }
  </style>
</head>

<body class="pg-sobre com-barra fonte-<?php echo $tamanho_fonte; ?> tema-<?php echo $tema_atual; ?>">

  <div id="barra-acessibilidade">
    <a href="<?php echo criarLink(['fonte' => 'grande']); ?>" class="btn-moderno btn-secundario" aria-label="Aumentar fonte">A+</a>
    <a href="<?php echo criarLink(['fonte' => 'medio']); ?>" class="btn-moderno btn-secundario" aria-label="Fonte normal">A</a>
    <a href="<?php echo criarLink(['fonte' => 'pequeno']); ?>" class="btn-moderno btn-secundario" aria-label="Diminuir fonte">A-</a>
    
    <?php if($tema_atual == 'padrao'): ?>
        <a href="<?php echo criarLink(['tema' => 'alto-contraste']); ?>" class="btn-moderno btn-secundario">⚡ Contraste</a>
    <?php else: ?>
        <a href="<?php echo criarLink(['tema' => 'padrao']); ?>" class="btn-moderno btn-secundario">⚪ Normal</a>
    <?php endif; ?>

    <button id="btnOuvir" onclick="lerTexto()" class="btn-moderno btn-secundario">🔊 Ouvir Texto</button>
    <button id="btnParar" onclick="pararTexto()" class="btn-moderno btn-perigo" style="display:none;">⏹️ Parar</button>
  </div>

  <div class="container sobre-container">
    <h1 style="color:white;"; class="titulo-destaque">Bem-vindo ao Accessibility Fitness</h1>
    <p style="color:white;">Academia acessível para pessoas com deficiência visual.</p>

    <figure style="margin: 20px 0; text-align: center;">
    <img src="tela_oficial.png" alt="Dois fisiculturistas segurando a Terra" style="max-width: 60%; height: 40%;">      <figcaption style="margin-top: 8px; font-style: italic; color: white;">A cena mostra dois fisiculturistas de corpo inteiro.</figcaption>
    </figure>

    <h2 style="color:white;" class="titulo-destaque">Acessibilidade: Nosso Compromisso</h2>
    <p style="color:white;">O <strong>Accessibility Fitness</strong> foi criado para pessoas com deficiência visual, focando na inclusão através do esporte.</p>

    <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">
    
    <h2 style="color:white;"; class="titulo-destaque">Experiências Inspiradoras</h2>
    
    <div style="background: #f8f9fa; padding: 20px; border-radius: 15px; border: 1px solid #eee;">
        <form action="" method="GET" style="display: flex; flex-direction: column; align-items: center;">
            <input type="hidden" name="tema" value="<?php echo $tema_atual; ?>">
            <input type="hidden" name="fonte" value="<?php echo $tamanho_fonte; ?>">

            <label style="color:black;"; for="videoSelect" style="margin-bottom: 10px; font-weight: bold;">Escolha um treino:</label>
            <select style="color:black;"; id="videoSelect" name="video">
                <option value="">-- Selecione um conteúdo --</option>
                <option value="video1" <?php if($video_escolhido == 'video1') echo 'selected'; ?>>Treino Adaptado</option>
                <option value="video2" <?php if($video_escolhido == 'video2') echo 'selected'; ?>>Dança Inclusiva</option>
                <option value="video3" <?php if($video_escolhido == 'video3') echo 'selected'; ?>>Artes Marciais</option>
            </select>
            <button style="color:white;"; type="submit" class="btn-moderno btn-primario">Visualizar Vídeo</button>
        </form>
    </div>

    <?php if ($video_escolhido && isset($videosData[$video_escolhido])): ?>
        <div id="area-video" style="margin-top:30px; border: 1px solid #ddd; padding:20px; border-radius: 10px; background: #fff;">
            <h3 class="titulo-destaque" style="margin-top: 0;"><?php echo $videosData[$video_escolhido]['titulo']; ?></h3>
            <p style="margin-bottom: 20px;"><em><?php echo $videosData[$video_escolhido]['desc']; ?></em></p>
            <div style="border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                <video controls width="100%" style="display: block;">
                    <source src="<?php echo $videosData[$video_escolhido]['src']; ?>" type="video/mp4">Your browser does not support the video tag.
                </video>
            </div>
        </div>
    <?php endif; ?>

    <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">
    
    <nav style="color:white;"; style="margin-top: 30px; text-align: center; padding-bottom: 20px;">
        <a href="treino.php" class="nav-btn-redondo">Treinos</a>
        <a href="anabolizante.php" class="nav-btn-redondo">Anabolizantes</a>
        <a href="suplementos.php" class="nav-btn-redondo">Suplementos</a>
        <a href="contato.html" class="nav-btn-redondo">Contato</a>
        <a href="pagina_principal.php" class="nav-btn-redondo">Início</a>

    </nav>
  </div>

<script>
    var textoParaLer = <?php echo json_encode($texto_audio); ?>;
    var synthesis = window.speechSynthesis;
    var utterance = null;

    function lerTexto() {
        if (!textoParaLer) return;
        synthesis.cancel();
        utterance = new SpeechSynthesisUtterance(textoParaLer);
        utterance.lang = 'pt-BR';
        utterance.onstart = function() { document.getElementById('btnOuvir').style.display = 'none'; document.getElementById('btnParar').style.display = 'inline-block'; };
        utterance.onend = function() { resetarBotoes(); };
        utterance.onerror = function() { resetarBotoes(); };
        synthesis.speak(utterance);
    }
    function pararTexto() { synthesis.cancel(); resetarBotoes(); }
    function resetarBotoes() { document.getElementById('btnOuvir').style.display = 'inline-block'; document.getElementById('btnParar').style.display = 'none'; }
</script>
</body>
</html>