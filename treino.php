<?php
// --- LÓGICA PHP (BACK-END) ---

function limpar($dado) {
    return htmlspecialchars($dado, ENT_QUOTES, 'UTF-8');
}

$treinosData = [
    'triceps' => [
        'titulo' => 'Treino de Tríceps',
        'imagem' => 'https://static.strengthlevel.com/images/exercises/tricep-pushdown/tricep-pushdown-800.jpg',
        'exercicios' => [
            ['nome' => 'Tríceps Pulley', 'desc' => 'Puxar a barra para baixo estendendo os braços com postura ereta.'],
            ['nome' => 'Tríceps Testa', 'desc' => 'Deitado, flexionar os cotovelos levando a barra em direção à testa.']
        ]
    ], // Adicionei a vírgula que faltava aqui
    'costas' => [
        'titulo' => 'Treino de Costas',
        'imagem' => 'https://static.strengthlevel.com/images/exercises/lat-pulldown/lat-pulldown-800.jpg',
        'exercicios' => [
            ['nome' => 'Puxada Frontal', 'desc' => 'Sentado, puxar a barra em direção ao peito, contraindo as escápulas.']
        ]
    ],
    'peito' => [
        'titulo' => 'Treino de Peito',
        'imagem' => 'https://static.strengthlevel.com/images/exercises/bench-press/bench-press-800.jpg',
        'exercicios' => [
            ['nome' => 'Supino Reto', 'desc' => 'Empurrar a barra para cima a partir do peito.']
        ]
    ],
    'pernas' => [
        'titulo' => 'Treino de Pernas',
        'imagem' => 'https://static.strengthlevel.com/images/exercises/squat/squat-800.jpg',
        'exercicios' => [
            ['nome' => 'Agachamento', 'desc' => 'Flexionar os joelhos como se fosse sentar em uma cadeira invisível.']
        ]
    ]
];

$temas_permitidos = ['padrao', 'alto-contraste'];
$fontes_permitidas = ['pequeno', 'medio', 'grande'];

$tema_atual = (isset($_GET['tema']) && in_array($_GET['tema'], $temas_permitidos)) ? $_GET['tema'] : 'padrao';
$tamanho_fonte = (isset($_GET['fonte']) && in_array($_GET['fonte'], $fontes_permitidas)) ? $_GET['fonte'] : 'medio';
// 'ler' removido pois agora é via JS
$grupo_selecionado = (isset($_GET['grupo']) && array_key_exists($_GET['grupo'], $treinosData)) ? $_GET['grupo'] : '';

function criarLink($params) {
    global $tema_atual, $tamanho_fonte, $grupo_selecionado;
    
    $estado_atual = [
        'tema' => $tema_atual,
        'fonte' => $tamanho_fonte,
        'grupo' => $grupo_selecionado
    ];
    
    $novos = array_merge($estado_atual, $params);
    return "?" . http_build_query($novos);
}

// Lógica de Texto para Áudio (Gerado pelo PHP, lido pelo JS)
$texto_audio = "Bem-vindo ao Guia de Treinos. ";

if ($grupo_selecionado) {
    $dados = $treinosData[$grupo_selecionado];
    $texto_audio = "Você selecionou " . $dados['titulo'] . ". ";
    $texto_audio .= "Exercícios: ";
    foreach($dados['exercicios'] as $ex) {
        $texto_audio .= $ex['nome'] . ". ";
    }
} else {
    $texto_audio .= "Por favor, selecione um grupo muscular abaixo.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Guia de Treinos - Acessibilidade PHP</title>
  <link rel="stylesheet" href="style.css">
  
  <style>
    * { box-sizing: border-box; }
    body { font-family: Arial, sans-serif; margin: 0; padding-bottom: 50px; }

    body.fonte-pequeno { font-size: 14px; }
    body.fonte-medio   { font-size: 18px; }
    body.fonte-grande  { font-size: 24px; }

    body.tema-alto-contraste { background-color: #222; color: #FFF000; }

    .barra-acessibilidade { padding: 15px; background: #eee; text-align: center; border-bottom: 1px solid #ccc; margin-bottom: 20px; }
    .btn-acess { text-decoration: none; padding: 5px 10px; background: #007bff; color: white; border: 1px solid currentColor; border-radius: 4px; margin: 0 5px; display: inline-block; cursor: pointer; font-weight: bold; border: none; font-size: 1rem; font-family: inherit; }

    main { max-width: 800px; margin: 0 auto; padding: 0 15px; }
    /* Estilo do Card Azul Escuro */
    .card { padding: 20px; background: #00264d; color: white; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }

    .img-treino { max-width: 100%; height: auto; border-radius: 4px; margin: 10px 0; display: block; }

    .btn-submit { padding: 10px 20px; cursor: pointer; background-color: #007bff; color: white; border: none; border-radius: 4px; font-weight: bold; }
  </style>
</head>

<body class="fonte-<?php echo limpar($tamanho_fonte); ?> tema-<?php echo limpar($tema_atual); ?>">

  <div style="font-size:90%;" class="barra-acessibilidade">
    <a style="color:white; background:#007bff;" href="<?php echo criarLink(['fonte' => 'pequeno']); ?>" class="btn-acess"><b>A-</a>
    <a style="color:white; background:#007bff;" href="<?php echo criarLink(['fonte' => 'medio']); ?>" class="btn-acess">A</a>
    <a style="color:white; background:#007bff;" href="<?php echo criarLink(['fonte' => 'grande']); ?>" class="btn-acess">A+</a>

    <span style="margin: 0 15px;">|</span>

    <?php if($tema_atual == 'padrao'): ?>
        <a style="color:white;" href="<?php echo criarLink(['tema' => 'alto-contraste']); ?>" class="btn-acess">⚡ Contraste</a>
    <?php else: ?>
        <a style="color:white;" href="<?php echo criarLink(['tema' => 'padrao']); ?>" class="btn-acess">⚪ Tema Normal</a>
    <?php endif; ?>

    <span style="margin: 0 15px;">|</span>

    <!-- Botões de Áudio JS -->
    <button id="btnOuvir" onclick="lerTexto()" class="btn-acess" style="color:white;">🔊 Ouvir Página</button>
    <button id="btnParar" onclick="pararTexto()" class="btn-acess" style="background:red; color:white; display:none;">⏹️ Parar Áudio</button>
  </div>

  <main>
    <h1 style="color:#ffcc00;">Guia de Exercícios</h1>

    <div class="card">
        <form method="GET" action="">
            <input type="hidden" name="tema" value="<?php echo limpar($tema_atual); ?>">
            <input type="hidden" name="fonte" value="<?php echo limpar($tamanho_fonte); ?>">

            <label for="grupo"><strong>Escolha o Músculo:</strong></label><br><br>
            <select name="grupo" id="grupo" style="padding: 8px; width: 100%; max-width: 300px; color: #333;">
                <option value="">-- Selecione --</option>

                <?php foreach($treinosData as $chave => $dados): ?>
                    <option value="<?php echo $chave; ?>" <?php if($grupo_selecionado == $chave) echo 'selected'; ?>>
                        <?php echo $dados['titulo']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <br><br>
            <button type="submit" class="btn-submit">Ver Exercícios</button>
            <a href="index.html?tema=<?php echo $tema_atual; ?>&fonte=<?php echo $tamanho_fonte; ?>" class="btn-nav" style="background:#ffcc00; color:black; text-decoration:none;">Voltar ao Menu Principal</a>

        </form>
    </div>

    <?php if ($grupo_selecionado): ?>
        <?php $dadosTreino = $treinosData[$grupo_selecionado]; ?>

        <h2><?php echo limpar($dadosTreino['titulo']); ?></h2>

        <div class="card" style="text-align:center;">
            <h3>Anatomia e Execução</h3>

            <img src="<?php echo $dadosTreino['imagem']; ?>"
                 alt="Imagem demonstrativa de <?php echo limpar($dadosTreino['titulo']); ?>"
                 class="img-treino">
        </div>

        <?php foreach($dadosTreino['exercicios'] as $ex): ?>
            <div class="card">
                <h3><?php echo limpar($ex['nome']); ?></h3>
                <p><strong>Como fazer:</strong> <?php echo limpar($ex['desc']); ?></p>
            </div>
        <?php endforeach; ?>

        <a href="<?php echo criarLink(['grupo' => '']); ?>" class="btn-acess" style="color:white;">← Voltar / Limpar</a>

    <?php endif; ?>

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
<script src="theme-toggle.js"></script>
</html>