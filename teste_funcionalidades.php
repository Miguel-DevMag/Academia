<?php
/**
 * teste_funcionalidades.php - Testa se todas as funcionalidades estão implementadas
 */

require_once 'conexao.php';
require_once 'auth_config.php';

$testes = [];

// Teste 1: Conexão com BD
try {
    $result = $conn->query("SELECT COUNT(*) as total FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'academia'");
    $row = $result->fetch_assoc();
    $testes['Banco de Dados'] = [
        'status' => 'OK',
        'mensagem' => $row['total'] . ' tabelas criadas'
    ];
} catch (Exception $e) {
    $testes['Banco de Dados'] = [
        'status' => 'ERRO',
        'mensagem' => $e->getMessage()
    ];
}

// Teste 2: Tabela Users
$testes['Tabela Users'] = verificarTabela($conn, 'users');

// Teste 3: Tabela Videos
$testes['Tabela Videos'] = verificarTabela($conn, 'videos');

// Teste 4: Tabela Treinos
$testes['Tabela Treinos'] = verificarTabela($conn, 'treinos');

// Teste 5: Tabela Suplementos
$testes['Tabela Suplementos'] = verificarTabela($conn, 'suplementos');

// Teste 6: Tabela Anabolizantes
$testes['Tabela Anabolizantes'] = verificarTabela($conn, 'anabolizantes');

// Teste 7: Tabela Depoimentos
$testes['Tabela Depoimentos'] = verificarTabela($conn, 'depoimentos');

// Teste 8: Tabela Contatos
$testes['Tabela Contatos'] = verificarTabela($conn, 'contatos');

// Teste 9: Verificar Arquivos
$arquivos_necessarios = [
    'admin_videos.php',
    'admin_treinos.php',
    'admin_suplementos.php',
    'admin_anabolizantes.php',
    'admin_depoimentos.php',
    'admin_contatos.php',
    'editar_video.php',
    'editar_treino.php',
    'editar_suplemento.php',
    'editar_anabolizante.php',
    'editar_depoimento.php',
    'contato.php',
    'auth_config.php',
    'login.php',
    'criar_conta.php',
    'logout.php',
    'perfil.php'
];

foreach ($arquivos_necessarios as $arquivo) {
    if (file_exists($arquivo)) {
        $testes['Arquivo: ' . $arquivo] = [
            'status' => 'OK',
            'mensagem' => 'Arquivo encontrado'
        ];
    } else {
        $testes['Arquivo: ' . $arquivo] = [
            'status' => 'ERRO',
            'mensagem' => 'Arquivo não encontrado'
        ];
    }
}

$conn->close();

function verificarTabela($conn, $tabela) {
    $result = $conn->query("SHOW TABLES LIKE '$tabela'");
    if ($result->num_rows > 0) {
        return [
            'status' => 'OK',
            'mensagem' => 'Tabela criada corretamente'
        ];
    } else {
        return [
            'status' => 'ERRO',
            'mensagem' => 'Tabela não encontrada'
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testes do Sistema - Academia</title>
    <style>
        body {
            font-family: 'Lexend', sans-serif;
            background: linear-gradient(135deg, #001f3f, #003366);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .test-group {
            margin-bottom: 20px;
        }
        .test-item {
            display: flex;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            border-left: 4px solid;
            align-items: center;
        }
        .test-ok {
            background: #d4edda;
            border-color: #28a745;
        }
        .test-error {
            background: #f8d7da;
            border-color: #dc3545;
        }
        .test-status {
            font-weight: bold;
            margin-right: 15px;
            min-width: 60px;
        }
        .test-ok .test-status {
            color: #155724;
        }
        .test-error .test-status {
            color: #721c24;
        }
        .test-info {
            flex: 1;
        }
        .test-info h3 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }
        .test-info p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #666;
        }
        .summary {
            background: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
            text-align: center;
        }
        .summary h2 {
            margin: 0 0 15px 0;
            color: #333;
        }
        .summary p {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
        }
        .success {
            color: #28a745;
        }
        .error {
            color: #dc3545;
        }
        .back-btn {
            display: inline-block;
            padding: 12px 24px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .back-btn:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.html" class="back-btn">← Voltar</a>
        <h1>✅ Testes do Sistema - Academia</h1>

        <div class="test-group">
            <?php foreach ($testes as $nome => $teste): ?>
                <div class="test-item <?php echo $teste['status'] === 'OK' ? 'test-ok' : 'test-error'; ?>">
                    <span class="test-status">
                        <?php echo $teste['status'] === 'OK' ? '✅' : '❌'; ?>
                    </span>
                    <div class="test-info">
                        <h3><?php echo htmlspecialchars($nome); ?></h3>
                        <p><?php echo htmlspecialchars($teste['mensagem']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="summary">
            <h2>Resumo dos Testes</h2>
            <?php 
                $total = count($testes);
                $ok = count(array_filter($testes, fn($t) => $t['status'] === 'OK'));
                $erros = $total - $ok;
            ?>
            <p class="success">✅ Passou: <?php echo $ok; ?>/<?php echo $total; ?></p>
            <?php if ($erros > 0): ?>
                <p class="error">❌ Erros: <?php echo $erros; ?></p>
            <?php else: ?>
                <p class="success">🎉 Todos os testes passaram!</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
