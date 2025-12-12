<?php
/**
 * editar_video.php - Editar um vídeo existente
 */

require_once 'auth_config.php';
requireLogin('login.php');

$conn = getDbConnection();
$mensagem = "";
$erro = "";
$video = null;

// Obter ID do vídeo
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id === 0) {
    header("Location: admin_videos.php");
    exit;
}

// READ - Obter dados do vídeo
$stmt = $conn->prepare("SELECT id, titulo, descricao, src FROM videos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: admin_videos.php");
    exit;
}

$video = $result->fetch_assoc();
$stmt->close();

// UPDATE - Atualizar vídeo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $src = trim($_POST['src'] ?? '');
    
    if (empty($titulo) || empty($src)) {
        $erro = "Título e fonte do vídeo são obrigatórios.";
    } else {
        $stmt = $conn->prepare("UPDATE videos SET titulo = ?, descricao = ?, src = ? WHERE id = ?");
        $stmt->bind_param("sssi", $titulo, $descricao, $src, $id);
        
        if ($stmt->execute()) {
            $mensagem = "✅ Vídeo atualizado com sucesso!";
            $video['titulo'] = $titulo;
            $video['descricao'] = $descricao;
            $video['src'] = $src;
        } else {
            $erro = "Erro ao atualizar vídeo: " . $stmt->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vídeo - Academia</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Lexend', sans-serif;
            background: linear-gradient(135deg, #001f3f, #003366);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 800px;
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
        .form-group {
            margin-bottom: 20px;
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
            margin-right: 10px;
        }
        .btn-primary {
            background: #ec1313;
            color: white;
        }
        .btn-primary:hover {
            background: #d10a0a;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
            text-decoration: none;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .button-group {
            text-align: center;
            margin-top: 30px;
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
        <a href="admin_videos.php" class="back-btn">← Voltar</a>
        <h1>✏️ Editar Vídeo</h1>

        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-success"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <?php if (!empty($erro)): ?>
            <div class="alert alert-error"><?php echo $erro; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="titulo">Título do Vídeo *</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($video['titulo']); ?>" required>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao" rows="4"><?php echo htmlspecialchars($video['descricao'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="src">URL/Caminho do Vídeo *</label>
                <input type="text" id="src" name="src" value="<?php echo htmlspecialchars($video['src']); ?>" required>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="admin_videos.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
