<?php
/**
 * admin_depoimentos.php - Gerenciador de Depoimentos (CRUD)
 */

require_once 'auth_config.php';
requireLogin('login.php');

$conn = getDbConnection();
$mensagem = "";
$erro = "";

// CREATE - Adicionar depoimento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'criar') {
    $nome = trim($_POST['nome'] ?? '');
    $texto = trim($_POST['texto'] ?? '');
    $video_src = trim($_POST['video_src'] ?? '');
    
    if (empty($nome) || empty($texto)) {
        $erro = "Nome e texto do depoimento são obrigatórios.";
    } else {
        $stmt = $conn->prepare("INSERT INTO depoimentos (nome, texto, video_src) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $texto, $video_src);
        
        if ($stmt->execute()) {
            $mensagem = "✅ Depoimento adicionado com sucesso!";
        } else {
            $erro = "Erro ao adicionar: " . $stmt->error;
        }
        $stmt->close();
    }
}

// DELETE - Deletar depoimento
if (isset($_GET['deletar'])) {
    $id = intval($_GET['deletar']);
    $stmt = $conn->prepare("DELETE FROM depoimentos WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $mensagem = "✅ Depoimento deletado com sucesso!";
    } else {
        $erro = "Erro ao deletar.";
    }
    $stmt->close();
}

// READ - Listar todos
$result = $conn->query("SELECT id, nome, texto, video_src, created_at FROM depoimentos ORDER BY created_at DESC");
$depoimentos = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Depoimentos - Academia</title>
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
            border-left: 4px solid #ec1313;
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
        .card-text {
            background: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border-left: 3px solid #007bff;
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
        <h1>⭐ Gerenciar Depoimentos</h1>

        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-success"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <?php if (!empty($erro)): ?>
            <div class="alert alert-error"><?php echo $erro; ?></div>
        <?php endif; ?>

        <!-- Formulário para adicionar -->
        <div class="form-section">
            <h2>Adicionar Novo Depoimento</h2>
            <form method="POST">
                <input type="hidden" name="acao" value="criar">
                
                <div class="form-group">
                    <label for="nome">Nome da Pessoa *</label>
                    <input type="text" id="nome" name="nome" required placeholder="Ex: João Silva">
                </div>

                <div class="form-group">
                    <label for="texto">Depoimento *</label>
                    <textarea id="texto" name="texto" rows="4" required placeholder="Escreva o depoimento..."></textarea>
                </div>

                <div class="form-group">
                    <label for="video_src">URL do Vídeo (opcional)</label>
                    <input type="text" id="video_src" name="video_src" placeholder="Ex: videos/depoimento.mp4">
                </div>

                <button type="submit" class="btn btn-primary">Adicionar Depoimento</button>
            </form>
        </div>

        <!-- Lista -->
        <div class="list">
            <h2>Depoimentos Cadastrados (<?php echo count($depoimentos); ?>)</h2>
            
            <?php if (empty($depoimentos)): ?>
                <p style="text-align: center; color: #999;">Nenhum depoimento cadastrado.</p>
            <?php else: ?>
                <?php foreach ($depoimentos as $item): ?>
                    <div class="card">
                        <h3><?php echo htmlspecialchars($item['nome']); ?></h3>
                        <p><strong>Data:</strong> <?php echo date('d/m/Y H:i', strtotime($item['created_at'])); ?></p>
                        
                        <div class="card-text">
                            <?php echo htmlspecialchars($item['texto']); ?>
                        </div>
                        
                        <?php if (!empty($item['video_src'])): ?>
                            <p><strong>Vídeo:</strong> <?php echo htmlspecialchars($item['video_src']); ?></p>
                        <?php endif; ?>
                        
                        <div class="actions">
                            <a href="editar_depoimento.php?id=<?php echo $item['id']; ?>" class="btn btn-secondary">Editar</a>
                            <a href="?deletar=<?php echo $item['id']; ?>" class="btn btn-danger" onclick="return confirm('Confirmar exclusão?');">Deletar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
