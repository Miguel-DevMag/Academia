<?php
// --- LÓGICA PHP (BACK-END) ---

// 1. Captura configurações da URL
$tema_atual = isset($_GET['tema']) ? $_GET['tema'] : 'padrao';
$tamanho_fonte = isset($_GET['fonte']) ? $_GET['fonte'] : 'medio';

// 2. Função para criar os links sem perder as configurações
function criarLink($params) {
    global $tema_atual, $tamanho_fonte;
    // Mescla configurações atuais com as novas
    $novos = array_merge([
        'tema' => $tema_atual,
        'fonte' => $tamanho_fonte
    ], $params);
    return "?" . http_build_query($novos);
}

// 3. Texto que será lido pelo JavaScript (ATUALIZADO PARA O NOVO VÍDEO)
$texto_para_ler = "Página de Depoimentos. Assista ao vídeo de Fabiano em um treino intenso. " .
                  "Descrição visual: Fabiano veste uma regata do Superman e óculos escuros. " .
                  "Ele realiza exercícios de desenvolvimento de ombros na máquina e levantamento terra, finalizando com uma pose de bíceps ao lado de um amigo.";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Depoimentos - Accessibility Fitness</title>
  <link rel="stylesheet" href="style.css">

  <style>
    /* Estilos Básicos */
    body { font-family: sans-serif; line-height: 1.6; margin: 0; }

    /* Estilos essenciais para a troca de tema funcionar */
    body.fonte-pequeno { font-size: 14px; }
    body.fonte-medio   { font-size: 18px; }
    body.fonte-grande  { font-size: 24px; }

    body.tema-alto-contraste { background-color: black !important; color: yellow !important; }
    body.tema-alto-contraste section { border-color: yellow !important; }
    body.tema-alto-contraste a { color: #00FF00 !important; }
    body.tema-alto-contraste .btn-acess { border: 1px solid white; background: #333; color: yellow; }
    body.tema-alto-contraste .descricao-detalhada { background-color: #222; border-left-color: yellow; color: yellow; }

    /* Barra de Acessibilidade */
    #barra-acessibilidade { padding: 15px; background: #eee; text-align: center; border-bottom: 2px solid #ccc; margin-bottom: 20px; }
    body.tema-alto-contraste #barra-acessibilidade { background: #000; border-bottom: 1px solid yellow; }
    
    .btn-acess {
        text-decoration: none; padding: 8px 12px; background: #007bff; color: white; 
        border-radius: 4px; margin: 0 5px; display: inline-block; font-weight: bold;
        cursor: pointer; border: none; font-size: 1rem; font-family: inherit;
    }

    /* Layout */
    main { max-width: 800px; margin: 0 auto; padding: 15px; }

    /* Caixa de Descrição */
    .descricao-detalhada {
        background-color: #f8f9fa;
        padding: 15px;
        border-left: 5px solid #28a745; /* Verde para diferenciar */
        margin-top: 10px;
        border-radius: 5px;
    }
    
    .info-box {
        padding: 20px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 20px;
    }
  </style>
</head>

<body class="pg-interna com-barra fonte-<?php echo $tamanho_fonte; ?> tema-<?php echo $tema_atual; ?>">

  <div id="barra-acessibilidade">
    <a href="<?php echo criarLink(['fonte' => 'grande']); ?>" class="btn-acess" aria-label="Aumentar fonte">A+</a>
    <a href="<?php echo criarLink(['fonte' => 'medio']); ?>" class="btn-acess" aria-label="Fonte normal">A</a>
    <a href="<?php echo criarLink(['fonte' => 'pequeno']); ?>" class="btn-acess" aria-label="Diminuir fonte">A-</a>

    <?php if($tema_atual == 'padrao'): ?>
        <a href="<?php echo criarLink(['tema' => 'alto-contraste']); ?>" class="btn-acess">⚡ Contraste</a>
    <?php else: ?>
        <a href="<?php echo criarLink(['tema' => 'padrao']); ?>" class="btn-acess">⚪ Normal</a>
    <?php endif; ?>

    <button id="btnOuvir" onclick="lerTexto()" class="btn-acess">🔊 Ouvir Página</button>
    <button id="btnParar" onclick="pararTexto()" class="btn-acess" style="background:red; display:none;">⏹️ Parar Áudio</button>
  </div>

  <main>
    <h1>Depoimentos</h1>
    
    <section class="info-box">
      <h2>História do Fabiano</h2>
      
      <video controls width="100%" style="border-radius: 8px;">
        <source src="treino1.mp4" type="video/mp4">
        Seu navegador não suporta vídeos.
      </video>

      <p style="font-weight: bold; margin-top: 10px;">Tema: Treino de força e estilo.</p>

      <div style="color:black;" class="descricao-detalhada">
        <h3 style="margin-top:0;">Audiodescrição (O que acontece no vídeo):</h3>
        <p>
            O vídeo mostra Fabiano treinando na academia com bastante estilo e intensidade. 
            Ele veste uma regata com o símbolo do Superman, shorts azuis e óculos escuros.
            <br><br>
            Primeiro, ele aparece no aparelho de desenvolvimento de ombros, empurrando uma carga pesada para cima.
            Em seguida, ele executa um exercício de levantamento terra (tração de costas/pernas) em pé.
            Ao final, ele sorri e flexiona o bíceps posando ao lado de um amigo de camiseta laranja.
        </p>
      </div>

    </section>
    
    <br>
    <a href="index.php?tema=<?php echo $tema_atual; ?>&fonte=<?php echo $tamanho_fonte; ?>" class="btn-acess" style="background:#555; text-decoration:none;">Voltar ao Menu</a>
  </main>

  <script>
      // Recebe o texto do PHP de forma segura
      var textoParaLer = <?php echo json_encode($texto_para_ler); ?>;
      
      var synthesis = window.speechSynthesis;
      var utterance = null;

      function lerTexto() {
          if (!textoParaLer) return;

          synthesis.cancel(); // Cancela falas anteriores

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