<?php
/**
 * admin_suplementos.php - Gerenciador de Suplementos (CRUD)
 */

require_once 'auth_config.php';
requireLogin('login.php');

$conn = getDbConnection();
$mensagem = "";
$erro = "";

// CREATE - Adicionar novo suplemento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'criar') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = isset($_POST['preco']) && !empty($_POST['preco']) ? floatval($_POST['preco']) : NULL;
    
    if (empty($nome)) {
        $erro = "Nome do suplemento é obrigatório.";
    } else {
        $stmt = $conn->prepare("INSERT INTO suplementos (nome, descricao, preco) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $nome, $descricao, $preco);
        
        if ($stmt->execute()) {
            $mensagem = "✅ Suplemento adicionado com sucesso!";
        } else {
            $erro = "Erro ao adicionar suplemento: " . $stmt->error;
        }
        $stmt->close();
    }
}

// DELETE - Deletar suplemento
if (isset($_GET['deletar'])) {
    $id = intval($_GET['deletar']);
    $stmt = $conn->prepare("DELETE FROM suplementos WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $mensagem = "✅ Suplemento deletado com sucesso!";
    } else {
        $erro = "Erro ao deletar suplemento.";
    }
    $stmt->close();
}

// READ - Listar todos os suplementos
$result = $conn->query("SELECT id, nome, descricao, preco, criado_em FROM suplementos ORDER BY criado_em DESC");
$suplementos = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Suplementos - Academia</title>
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
        .suplementos-list {
            margin-top: 30px;
        }
        .suplemento-card {
            background: #f9f9f9;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            border-left: 4px solid #ec1313;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .suplemento-info {
            flex: 1;
        }
        .suplemento-info h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .suplemento-info p {
            margin: 5px 0;
            color: #666;
            font-size: 0.9rem;
        }
        .suplemento-actions {
            display: flex;
            gap: 10px;
            margin-left: 20px;
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
        <h1>💊 Gerenciar Suplementos</h1>

        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-success"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <?php if (!empty($erro)): ?>
            <div class="alert alert-error"><?php echo $erro; ?></div>
        <?php endif; ?>

        <!-- Formulário para adicionar suplemento -->
        <div class="form-section">
            <h2>Adicionar Novo Suplemento</h2>
            <form method="POST">
                <input type="hidden" name="acao" value="criar">
                
                <div class="form-group">
                    <label for="nome">Nome do Suplemento *</label>
                    <input type="text" id="nome" name="nome" required placeholder="Ex: Whey Protein">
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="4" placeholder="Descreva os benefícios e composição..."></textarea>
                </div>

                <div class="form-group">
                    <label for="preco">Preço (R$)</label>
                    <input type="number" id="preco" name="preco" step="0.01" placeholder="Ex: 99.90">
                </div>

                <button type="submit" class="btn btn-primary">Adicionar Suplemento</button>
            </form>
        </div>

        <!-- Lista de suplementos -->
        <div class="suplementos-list">
            <h2>Suplementos Cadastrados (<?php echo count($suplementos); ?>)</h2>
            
            <?php if (empty($suplementos)): ?>
                <p style="text-align: center; color: #999;">Nenhum suplemento cadastrado ainda.</p>
            <?php else: ?>
                <?php foreach ($suplementos as $suplemento): ?>
                    <div class="suplemento-card">
                        <div class="suplemento-info">
                            <h3><?php echo htmlspecialchars($suplemento['nome']); ?></h3>
                            <p><strong>Descrição:</strong> <?php echo htmlspecialchars($suplemento['descricao'] ?? 'Sem descrição'); ?></p>
                            <p><strong>Preço:</strong> <?php echo !empty($suplemento['preco']) ? 'R$ ' . number_format($suplemento['preco'], 2, ',', '.') : 'Não informado'; ?></p>
                            <p><strong>Data:</strong> <?php echo date('d/m/Y H:i', strtotime($suplemento['criado_em'])); ?></p>
                        </div>
                        <div class="suplemento-actions">
                            <a href="editar_suplemento.php?id=<?php echo $suplemento['id']; ?>" class="btn btn-secondary">Editar</a>
                            <a href="?deletar=<?php echo $suplemento['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja deletar este suplemento?');">Deletar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
