<?php
// --- LÓGICA PHP (BACK-END) ---

// 1. Definição dos dados
$infoData = [
    'deca' => [
        'nome' => "Deca-Durabolin",
        'risco' => "Alta retenção líquida, acne severa e risco cardíaco."
    ],
    'dura' => [
        'nome' => "Durateston",
        'risco' => "Alterações hormonais agressivas, calvície e agressividade."
    ]
];

// Captura a escolha do usuário
$selecionado = isset($_GET['anabolizantes']) ? $_GET['anabolizantes'] : '';

// 2. Configurações de Acessibilidade
$tema_atual = isset($_GET['tema']) ? $_GET['tema'] : 'padrao';
$tamanho_fonte = isset($_GET['fonte']) ? $_GET['fonte'] : 'medio';
$grupo_selecionado = isset($_GET['grupo']) ? $_GET['grupo'] : '';

function criarLink($params) {
    global $tema_atual, $tamanho_fonte, $grupo_selecionado, $selecionado;
    $novos = array_merge([
        'tema' => $tema_atual,
        'fonte' => $tamanho_fonte,
        'grupo' => $grupo_selecionado,
        'anabolizantes' => $selecionado // Mantém a seleção atual ao mudar acessibilidade
    ], $params);
    return "?" . http_build_query($novos);
}

// 3. Preparação do Texto para Áudio (PHP gera, JS lê)
$texto_audio = "Alerta sobre Anabolizantes. Informação é a melhor prevenção. Selecione um item abaixo para saber os riscos.";

if ($selecionado && isset($infoData[$selecionado])) {
    $dados = $infoData[$selecionado];
    $texto_audio = "Você selecionou " . $dados['nome'] . ". Riscos principais: " . $dados['risco'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Alerta: Anabolizantes</title>
  <link rel="stylesheet" href="style.css">

  <style>
    /* CSS ACESSIBILIDADE (Igual ao guia de treinos) */
    body { font-family: sans-serif; margin: 0; }
    
    body.fonte-pequeno { font-size: 14px; }
    body.fonte-medio   { font-size: 18px; }
    body.fonte-grande  { font-size: 24px; }

    /* Tema Alto Contraste */
    body.tema-alto-contraste { background-color: black !important; color: yellow !important; }
    body.tema-alto-contraste .titulo-vermelho { color: #FF4500 !important; }
    body.tema-alto-contraste select, body.tema-alto-contraste button { 
        background-color: #333; color: yellow; border: 1px solid yellow; 
    }
    body.tema-alto-contraste a { color: #00FF00 !important; }
    body.tema-alto-contraste .info-box { border: 2px solid yellow; background: #222; }
    
    /* Botões da Barra */
    #barra-acessibilidade { padding: 15px; background: #eee; text-align: center; border-bottom: 2px solid #ccc; margin-bottom: 20px;}
    body.tema-alto-contraste #barra-acessibilidade { background: #000; border-bottom: 1px solid yellow; }
    
    .btn-acess {
        text-decoration: none; padding: 8px 12px; background: #007bff; color: white; 
        border-radius: 4px; margin: 0 5px; display: inline-block; font-weight: bold;
        cursor: pointer; border: none; font-size: 1rem; font-family: inherit;
    }

    /* Estilos Específicos */
    .titulo-vermelho { color: #dc3545; }
    main { max-width: 800px; margin: 0 auto; padding: 15px; text-align: center; }
    
    .info-box {
        margin-top: 20px; padding: 20px; background: #f8d7da; border-radius: 8px; border: 1px solid #f5c6cb; color: #721c24;
    }
    body.tema-alto-contraste .info-box { color: yellow; }

    select { padding: 10px; font-size: 1rem; margin-top: 10px; width: 100%; max-width: 400px; }
  </style>
</head>

<body class="pg-interna com-barra fonte-<?php echo $tamanho_fonte; ?> tema-<?php echo $tema_atual; ?>">

<div id="barra-acessibilidade">
    <a href="<?php echo criarLink(['fonte' => 'grande']); ?>" class="btn-acess">A+</a>
    <a href="<?php echo criarLink(['fonte' => 'medio']); ?>" class="btn-acess">A</a>
    <a href="<?php echo criarLink(['fonte' => 'pequeno']); ?>" class="btn-acess">A-</a>

    <?php if($tema_atual == 'padrao'): ?>
        <a href="<?php echo criarLink(['tema' => 'alto-contraste']); ?>" class="btn-acess">⚡ Contraste</a>
    <?php else: ?>
        <a href="<?php echo criarLink(['tema' => 'padrao']); ?>" class="btn-acess">⚪ Normal</a>
    <?php endif; ?>

    <!-- Botões de Áudio JS -->
    <button id="btnOuvir" onclick="lerTexto()" class="btn-acess">🔊 Ouvir</button>
    <button id="btnParar" onclick="pararTexto()" class="btn-acess" style="background:red; display:none;">⏹️ Parar</button>
</div>

<main>
    <h1 class="titulo-vermelho">⚠️ Alerta sobre Anabolizantes</h1>
    <p>Informação é a melhor prevenção.</p>

    <form action="" method="GET">
        <!-- Mantém acessibilidade ao submeter -->
        <input type="hidden" name="tema" value="<?php echo $tema_atual; ?>">
        <input type="hidden" name="fonte" value="<?php echo $tamanho_fonte; ?>">

        <label for="anabolizantes" style="font-weight:bold;">Selecione para saber os riscos:</label>
        <br>
        <select id="anabolizantes" name="anabolizantes" onchange="this.form.submit()">
            <option value="">-- Selecione --</option>
            <option value="deca" <?php if($selecionado == 'deca') echo 'selected'; ?>>Deca-Durabolin</option>
            <option value="dura" <?php if($selecionado == 'dura') echo 'selected'; ?>>Durateston</option>
        </select>
    </form>

    <?php if (array_key_exists($selecionado, $infoData)): ?>
        <div id="info-anabolizante" class="info-box">
            <h2 class="titulo-vermelho" ; style="color:#721c24"; style="margin-top:0;"><?php echo $infoData[$selecionado]['nome']; ?></h2>
            <p style="font-weight:bold;">Riscos:</p>
            <p><?php echo $infoData[$selecionado]['risco']; ?></p>
        </div>
    <?php endif; ?>
    
    <br>
    <a href="index.php?tema=<?php echo $tema_atual; ?>&fonte=<?php echo $tamanho_fonte; ?>" class="btn-acess" style="background:#555; text-decoration:none;">Voltar ao Menu</a>
</main>

<!-- SCRIPT JAVASCRIPT PARA ÁUDIO -->
<script>
    var textoParaLer = <?php echo json_encode($texto_audio); ?>;
    var synthesis = window.speechSynthesis;
    var utterance = null;

    function lerTexto() {
        if (!textoParaLer) return;
        synthesis.cancel(); // Para falas anteriores

        utterance = new SpeechSynthesisUtterance(textoParaLer);
        utterance.lang = 'pt-BR';
        utterance.rate = 1.0;

        utterance.onstart = function() {
            document.getElementById('btnOuvir').style.display = 'none';
            document.getElementById('btnParar').style.display = 'inline-block';
        };

        utterance.onend = function() {
            resetarBotoes();
        };

        utterance.onerror = function() {
            resetarBotoes();
        };

        synthesis.speak(utterance);
    }

    function pararTexto() {
        synthesis.cancel();
        resetarBotoes();
    }

    function resetarBotoes() {
        document.getElementById('btnOuvir').style.display = 'inline-block';
        document.getElementById('btnParar').style.display = 'none';
    }
</script>

</body>
</html>