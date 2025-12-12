<?php
// --- LÓGICA PHP (BACK-END) ---

// 1. Banco de Dados dos Treinos
$treinosData = [
    'triceps' => [
        'titulo' => 'Treino de Tríceps',
        // Inseri a imagem para não ficar vazio
        'diagrama' => '<img src="https://static.strengthlevel.com/images/exercises/tricep-pushdown/tricep-pushdown-800.jpg" alt="Anatomia Tríceps" style="max-width:100%; border-radius:8px;">',
        'exercicios' => [
            ['nome' => 'Tríceps Pulley', 'desc' => 'Puxar a barra para baixo estendendo os braços com postura ereta.'],
            ['nome' => 'Tríceps Testa', 'desc' => 'Deitado, flexionar os cotovelos levando a barra em direção à testa.']
        ]
    ],
    'costas' => [
        'titulo' => 'Treino de Costas',
        'diagrama' => '<img src="https://static.strengthlevel.com/images/exercises/lat-pulldown/lat-pulldown-800.jpg" alt="Anatomia Costas" style="max-width:100%; border-radius:8px;">',
        'exercicios' => [
            ['nome' => 'Puxada Frontal', 'desc' => 'Sentado, puxar a barra em direção ao peito, contraindo as escápulas.']
        ]
    ],
    'peito' => [
        'titulo' => 'Treino de Peito',
        'diagrama' => '<img src="https://static.strengthlevel.com/images/exercises/bench-press/bench-press-800.jpg" alt="Anatomia Peito" style="max-width:100%; border-radius:8px;">',
        'exercicios' => [
            ['nome' => 'Supino Reto', 'desc' => 'Empurrar a barra para cima a partir do peito.']
        ]
    ],
    'pernas' => [
        'titulo' => 'Treino de Pernas',
        'diagrama' => '<img src="https://static.strengthlevel.com/images/exercises/squat/squat-800.jpg" alt="Anatomia Pernas" style="max-width:100%; border-radius:8px;">',
        'exercicios' => [
            ['nome' => 'Agachamento', 'desc' => 'Flexionar os joelhos como se fosse sentar em uma cadeira invisível.']
        ]
    ]
];

// 2. Configurações de Acessibilidade
$tema_atual = isset($_GET['tema']) ? $_GET['tema'] : 'padrao';
$tamanho_fonte = isset($_GET['fonte']) ? $_GET['fonte'] : 'medio';
// 'ler' removido pois agora é via JS
$grupo_selecionado = isset($_GET['grupo']) ? $_GET['grupo'] : '';

function criarLink($params) {
    global $tema_atual, $tamanho_fonte, $grupo_selecionado;
    $novos = array_merge([
        'tema' => $tema_atual,
        'fonte' => $tamanho_fonte,
        'grupo' => $grupo_selecionado
    ], $params);
    return "?" . http_build_query($novos);
}

// 3. Texto para Áudio (PHP gera, JS lê)
$texto_audio = "Guia de Treinos. Escolha entre Tríceps, Costas, Peito ou Pernas para ver os exercícios.";

if ($grupo_selecionado && isset($treinosData[$grupo_selecionado])) {
    $texto_audio = "Exibindo " . $treinosData[$grupo_selecionado]['titulo'] . ". " . 
                   "Primeiro exercício: " . $treinosData[$grupo_selecionado]['exercicios'][0]['nome'] . ". " .
                   "Descrição: " . $treinosData[$grupo_selecionado]['exercicios'][0]['desc'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Guia de Treinos - Accessibility Fitness</title>
  <link rel="stylesheet" href="style.css">

  <style>
    /* CSS ACESSIBILIDADE */
    body.fonte-pequeno { font-size: 14px; }
    body.fonte-medio   { font-size: 18px; }
    body.fonte-grande  { font-size: 24px; }

    body.tema-alto-contraste { background-color: black !important; color: yellow !important; }
    body.tema-alto-contraste .exercicio { background-color: #222; border: 1px solid yellow; }
    body.tema-alto-contraste select, body.tema-alto-contraste button { 
        background-color: #333; color: yellow; border: 1px solid yellow; 
    }
    body.tema-alto-contraste a { color: #00FF00 !important; }

    /* Barra */
    #barra-acessibilidade { padding: 15px; background: #eee; text-align: center; border-bottom: 2px solid #ccc; margin-bottom: 20px;}
    body.tema-alto-contraste #barra-acessibilidade { background: #000; border-bottom: 1px solid yellow; }
    
    .btn-acess {
        text-decoration: none; padding: 8px 12px; background: #007bff; color: white; 
        border-radius: 4px; margin: 0 5px; display: inline-block; font-weight: bold;
        cursor: pointer; border: none; font-size: 1rem; font-family: inherit;
    }

    /* Estilos da Página */
    .frase-topo {
        font-style: italic; color: #555; background: #e9ecef; padding: 10px; border-radius: 5px; margin-bottom: 20px;
    }
    .exercicio {
        background: #fff; color: #333; padding: 15px; margin-bottom: 15px; 
        border-radius: 8px; border-left: 5px solid #007bff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .diagrama-container {
        text-align: center; margin-bottom: 20px; padding: 10px; background: #fff; border-radius: 8px;
    }
    .p3 {
        font-family: "Lucida Console", "Courier New", monospace;
    }
    
    .btn-nav {
        padding: 10px 20px; background: #fff; color: #00264d; border: none; font-weight:bold; cursor: pointer; border-radius: 4px;
    }
  </style>
</head>

<body class="pg-treinos com-barra fonte-<?php echo $tamanho_fonte; ?> tema-<?php echo $tema_atual; ?>">

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
    <h1>Guia de Exercícios</h1>
    <p class="p3"><i>"Aqui não tem 'eu não consigo', tem 'eu vou tentar'!"</i></p>

    <form action="#resultado" method="GET" style="background: #00264d; padding: 20px; border-radius: 10px; color: white;">
        <input type="hidden" name="tema" value="<?php echo $tema_atual; ?>">
        <input type="hidden" name="fonte" value="<?php echo $tamanho_fonte; ?>">

        <label for="grupoMuscular" style="font-weight:bold;">Escolha o grupo muscular:</label>
        <br>
        <select id="grupoMuscular" name="grupo" style="margin-top: 10px; width: 100%; max-width: 400px; padding: 10px;">
            <option value="">-- Selecione --</option>
            <?php foreach($treinosData as $chave => $dados): ?>
                <option value="<?php echo $chave; ?>" <?php if($grupo_selecionado == $chave) echo 'selected'; ?>>
                    <?php echo ucfirst($chave); ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <br><br>
        <button type="submit" class="btn-nav">Ver Exercícios</button>
    </form>

    <div id="resultado">
        <?php if ($grupo_selecionado && isset($treinosData[$grupo_selecionado])): ?>
            
            <hr>
            <h2><?php echo $treinosData[$grupo_selecionado]['titulo']; ?></h2>
            
            <?php if (trim($treinosData[$grupo_selecionado]['diagrama']) !== ''): ?>
                <div class="diagrama-container">
                    <h3>Anatomia do Músculo:</h3>
                    <?php echo $treinosData[$grupo_selecionado]['diagrama']; ?>
                </div>
            <?php endif; ?>

            <?php foreach($treinosData[$grupo_selecionado]['exercicios'] as $exercicio): ?>
                <article class="exercicio">
                    <h3><?php echo $exercicio['nome']; ?></h3>
                    <p><strong>Descrição:</strong> <?php echo $exercicio['desc']; ?></p>
                </article>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>

    <br>
    <a href="index.html?tema=<?php echo $tema_atual; ?>&fonte=<?php echo $tamanho_fonte; ?>" class="btn-nav" style="background:#555; color:white; text-decoration:none;">Voltar ao Menu Principal</a>

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
<script src="theme-toggle.js"></script>