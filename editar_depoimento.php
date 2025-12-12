<?php
/**
 * editar_depoimento.php - Editar depoimento
 */

require_once 'auth_config.php';
requireLogin('login.php');

$conn = getDbConnection();
$mensagem = "";
$erro = "";
$item = null;

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id === 0) {
    header("Location: admin_depoimentos.php");
    exit;
}

$stmt = $conn->prepare("SELECT id, nome, texto, video_src FROM depoimentos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: admin_depoimentos.php");
    exit;
}

$item = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $texto = trim($_POST['texto'] ?? '');
    $video_src = trim($_POST['video_src'] ?? '');
    
    if (empty($nome) || empty($texto)) {
        $erro = "Nome e texto são obrigatórios.";
    } else {
        $stmt = $conn->prepare("UPDATE depoimentos SET nome = ?, texto = ?, video_src = ? WHERE id = ?");
        $stmt->bind_param("sssi", $nome, $texto, $video_src, $id);
        
        if ($stmt->execute()) {
            $mensagem = "✅ Atualizado com sucesso!";
            $item['nome'] = $nome;
            $item['texto'] = $texto;
            $item['video_src'] = $video_src;
        } else {
            $erro = "Erro ao atualizar: " . $stmt->error;
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
    <title>Editar Depoimento - Academia</title>
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
        <a href="admin_depoimentos.php" class="back-btn">← Voltar</a>
        <h1>✏️ Editar Depoimento</h1>

        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-success"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <?php if (!empty($erro)): ?>
            <div class="alert alert-error"><?php echo $erro; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="nome">Nome da Pessoa *</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($item['nome']); ?>" required>
            </div>

            <div class="form-group">
                <label for="texto">Depoimento *</label>
                <textarea id="texto" name="texto" rows="5" required><?php echo htmlspecialchars($item['texto']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="video_src">URL do Vídeo (opcional)</label>
                <input type="text" id="video_src" name="video_src" value="<?php echo htmlspecialchars($item['video_src'] ?? ''); ?>">
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="admin_depoimentos.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
