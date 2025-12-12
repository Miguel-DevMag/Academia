<?php
/**
 * admin_anabolizantes.php - Gerenciador de Anabolizantes (CRUD)
 */

require_once 'auth_config.php';
requireLogin('login.php');

$conn = getDbConnection();
$mensagem = "";
$erro = "";

// CREATE - Adicionar novo anabolizante
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'criar') {
    $codigo = trim($_POST['codigo'] ?? '');
    $nome = trim($_POST['nome'] ?? '');
    $risco = trim($_POST['risco'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    
    if (empty($codigo) || empty($nome)) {
        $erro = "Código e nome são obrigatórios.";
    } else {
        $stmt = $conn->prepare("INSERT INTO anabolizantes (codigo, nome, risco, descricao) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $codigo, $nome, $risco, $descricao);
        
        if ($stmt->execute()) {
            $mensagem = "✅ Anabolizante adicionado com sucesso!";
        } else {
            $erro = "Erro ao adicionar: " . $stmt->error;
        }
        $stmt->close();
    }
}

// DELETE - Deletar anabolizante
if (isset($_GET['deletar'])) {
    $id = intval($_GET['deletar']);
    $stmt = $conn->prepare("DELETE FROM anabolizantes WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $mensagem = "✅ Anabolizante deletado com sucesso!";
    } else {
        $erro = "Erro ao deletar.";
    }
    $stmt->close();
}

// READ - Listar todos
$result = $conn->query("SELECT id, codigo, nome, risco, descricao, created_at FROM anabolizantes ORDER BY created_at DESC");
$anabolizantes = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Anabolizantes - Academia</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Lexend', sans-serif;
            background: linear-gradient(135deg, #001f3f, #003366);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
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
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .form-section {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            border: 2px solid #ec1313;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
            font-family: 'Lexend', sans-serif;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #ec1313;
            box-shadow: 0 0 5px rgba(236, 19, 19, 0.3);
        }
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            font-size: 1rem;
            transition: 0.3s;
        }
        .btn-primary {
            background: #ec1313;
            color: white;
        }
        .btn-primary:hover {
            background: #d10a0a;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        .btn-secondary {
            background: #007bff;
            color: white;
            text-decoration: none;
            display: inline-block;
        }
        .btn-secondary:hover {
            background: #0056b3;
        }
        .list {
            margin-top: 30px;
        }
        .card {
            background: #f9f9f9;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            border-left: 4px solid #dc3545;
        }
        .card h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .card p {
            margin: 5px 0;
            color: #666;
            font-size: 0.9rem;
        }
        .actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
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
    <script src="theme-toggle.js"></script>
</head>
<body>
    <div class="container">
        <a href="perfil.php" class="back-btn">← Voltar</a>
        <h1>⚠️ Gerenciar Anabolizantes</h1>

        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-success"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <?php if (!empty($erro)): ?>
            <div class="alert alert-error"><?php echo $erro; ?></div>
        <?php endif; ?>

        <!-- Formulário para adicionar -->
        <div class="form-section">
            <h2>Adicionar Novo Anabolizante</h2>
            <form method="POST">
                <input type="hidden" name="acao" value="criar">
                
                <div class="form-group">
                    <label for="codigo">Código *</label>
                    <input type="text" id="codigo" name="codigo" required placeholder="Ex: DECA">
                </div>

                <div class="form-group">
                    <label for="nome">Nome *</label>
                    <input type="text" id="nome" name="nome" required placeholder="Ex: Decanoato de Nandrolona">
                </div>

                <div class="form-group">
                    <label for="risco">Riscos</label>
                    <textarea id="risco" name="risco" rows="3" placeholder="Descreva os riscos à saúde..."></textarea>
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="3" placeholder="Informações gerais..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Adicionar</button>
            </form>
        </div>

        <!-- Lista -->
        <div class="list">
            <h2>Anabolizantes Cadastrados (<?php echo count($anabolizantes); ?>)</h2>
            
            <?php if (empty($anabolizantes)): ?>
                <p style="text-align: center; color: #999;">Nenhum anabolizante cadastrado.</p>
            <?php else: ?>
                <?php foreach ($anabolizantes as $item): ?>
                    <div class="card">
                        <h3><?php echo htmlspecialchars($item['nome']); ?> (<?php echo htmlspecialchars($item['codigo']); ?>)</h3>
                        <p><strong>Riscos:</strong> <?php echo htmlspecialchars($item['risco'] ?? 'Não informado'); ?></p>
                        <p><strong>Descrição:</strong> <?php echo htmlspecialchars($item['descricao'] ?? '-'); ?></p>
                        <p><strong>Data:</strong> <?php echo date('d/m/Y H:i', strtotime($item['created_at'])); ?></p>
                        <div class="actions">
                            <a href="editar_anabolizante.php?id=<?php echo $item['id']; ?>" class="btn btn-secondary">Editar</a>
                            <a href="?deletar=<?php echo $item['id']; ?>" class="btn btn-danger" onclick="return confirm('Confirmar exclusão?');">Deletar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
