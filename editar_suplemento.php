<?php
/**
 * editar_suplemento.php - Editar um suplemento existente
 */

require_once 'auth_config.php';
requireLogin('login.php');

$conn = getDbConnection();
$mensagem = "";
$erro = "";
$suplemento = null;

// Obter ID do suplemento
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id === 0) {
    header("Location: admin_suplementos.php");
    exit;
}

// READ - Obter dados do suplemento
$stmt = $conn->prepare("SELECT id, nome, descricao, preco FROM suplementos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: admin_suplementos.php");
    exit;
}

$suplemento = $result->fetch_assoc();
$stmt->close();

// UPDATE - Atualizar suplemento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = isset($_POST['preco']) && !empty($_POST['preco']) ? floatval($_POST['preco']) : NULL;
    
    if (empty($nome)) {
        $erro = "Nome do suplemento é obrigatório.";
    } else {
        $stmt = $conn->prepare("UPDATE suplementos SET nome = ?, descricao = ?, preco = ? WHERE id = ?");
        $stmt->bind_param("ssdi", $nome, $descricao, $preco, $id);
        
        if ($stmt->execute()) {
            $mensagem = "✅ Suplemento atualizado com sucesso!";
            $suplemento['nome'] = $nome;
            $suplemento['descricao'] = $descricao;
            $suplemento['preco'] = $preco;
        } else {
            $erro = "Erro ao atualizar suplemento: " . $stmt->error;
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
    <title>Editar Suplemento - Academia</title>
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
        <a href="admin_suplementos.php" class="back-btn">← Voltar</a>
        <h1>✏️ Editar Suplemento</h1>

        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-success"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <?php if (!empty($erro)): ?>
            <div class="alert alert-error"><?php echo $erro; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="nome">Nome do Suplemento *</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($suplemento['nome']); ?>" required>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea id="descricao" name="descricao" rows="4"><?php echo htmlspecialchars($suplemento['descricao'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label for="preco">Preço (R$)</label>
                <input type="number" id="preco" name="preco" step="0.01" value="<?php echo $suplemento['preco'] ?? ''; ?>">
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="admin_suplementos.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
