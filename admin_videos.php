<?php
/**
 * admin_videos.php - Gerenciador de Vídeos (CRUD)
 */

require_once 'auth_config.php';
requireLogin('login.php');

$conn = getDbConnection();
$mensagem = "";
$erro = "";

// CREATE - Adicionar novo vídeo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'criar') {
    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $src = trim($_POST['src'] ?? '');
    
    if (empty($titulo) || empty($src)) {
        $erro = "Título e fonte do vídeo são obrigatórios.";
    } else {
        $stmt = $conn->prepare("INSERT INTO videos (titulo, descricao, src) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $titulo, $descricao, $src);
        
        if ($stmt->execute()) {
            $mensagem = "✅ Vídeo adicionado com sucesso!";
        } else {
            $erro = "Erro ao adicionar vídeo: " . $stmt->error;
        }
        $stmt->close();
    }
}

// DELETE - Deletar vídeo
if (isset($_GET['deletar'])) {
    $id = intval($_GET['deletar']);
    $stmt = $conn->prepare("DELETE FROM videos WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $mensagem = "✅ Vídeo deletado com sucesso!";
    } else {
        $erro = "Erro ao deletar vídeo.";
    }
    $stmt->close();
}

// READ - Listar todos os vídeos
$result = $conn->query("SELECT id, titulo, descricao, src, created_at FROM videos ORDER BY created_at DESC");
$videos = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Vídeos - Academia</title>
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
        .videos-list {
            margin-top: 30px;
        }
        .video-card {
            background: #f9f9f9;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            border-left: 4px solid #ec1313;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .video-info {
            flex: 1;
        }
        .video-info h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .video-info p {
            margin: 5px 0;
            color: #666;
            font-size: 0.9rem;
        }
        .video-actions {
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
        <h1>📹 Gerenciar Vídeos</h1>

        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-success"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <?php if (!empty($erro)): ?>
            <div class="alert alert-error"><?php echo $erro; ?></div>
        <?php endif; ?>

        <!-- Formulário para adicionar vídeo -->
        <div class="form-section">
            <h2>Adicionar Novo Vídeo</h2>
            <form method="POST">
                <input type="hidden" name="acao" value="criar">
                
                <div class="form-group">
                    <label for="titulo">Título do Vídeo *</label>
                    <input type="text" id="titulo" name="titulo" required placeholder="Ex: Treino de Perna">
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="4" placeholder="Descreva o conteúdo do vídeo..."></textarea>
                </div>

                <div class="form-group">
                    <label for="src">URL/Caminho do Vídeo *</label>
                    <input type="text" id="src" name="src" required placeholder="Ex: videos/treino.mp4">
                </div>

                <button type="submit" class="btn btn-primary">Adicionar Vídeo</button>
            </form>
        </div>

        <!-- Lista de vídeos -->
        <div class="videos-list">
            <h2>Vídeos Cadastrados (<?php echo count($videos); ?>)</h2>
            
            <?php if (empty($videos)): ?>
                <p style="text-align: center; color: #999;">Nenhum vídeo cadastrado ainda.</p>
            <?php else: ?>
                <?php foreach ($videos as $video): ?>
                    <div class="video-card">
                        <div class="video-info">
                            <h3><?php echo htmlspecialchars($video['titulo']); ?></h3>
                            <p><strong>Descrição:</strong> <?php echo htmlspecialchars($video['descricao'] ?? 'Sem descrição'); ?></p>
                            <p><strong>Caminho:</strong> <?php echo htmlspecialchars($video['src']); ?></p>
                            <p><strong>Data:</strong> <?php echo date('d/m/Y H:i', strtotime($video['created_at'])); ?></p>
                        </div>
                        <div class="video-actions">
                            <a href="editar_video.php?id=<?php echo $video['id']; ?>" class="btn btn-secondary">Editar</a>
                            <a href="?deletar=<?php echo $video['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja deletar este vídeo?');">Deletar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
