<?php
/**
 * admin_treinos.php - Gerenciador de Treinos (CRUD)
 */

require_once 'auth_config.php';
requireLogin('login.php');

$conn = getDbConnection();
$mensagem = "";
$erro = "";

// CREATE - Adicionar novo treino
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'criar') {
    $grupo = trim($_POST['grupo'] ?? '');
    $titulo = trim($_POST['titulo'] ?? '');
    $exercicios = isset($_POST['exercicios']) ? json_encode($_POST['exercicios']) : '[]';
    
    if (empty($grupo) || empty($titulo)) {
        $erro = "Grupo muscular e título são obrigatórios.";
    } else {
        $stmt = $conn->prepare("INSERT INTO treinos (grupo, titulo, exercicios) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $grupo, $titulo, $exercicios);
        
        if ($stmt->execute()) {
            $mensagem = "✅ Treino adicionado com sucesso!";
        } else {
            $erro = "Erro ao adicionar treino: " . $stmt->error;
        }
        $stmt->close();
    }
}

// DELETE - Deletar treino
if (isset($_GET['deletar'])) {
    $id = intval($_GET['deletar']);
    $stmt = $conn->prepare("DELETE FROM treinos WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $mensagem = "✅ Treino deletado com sucesso!";
    } else {
        $erro = "Erro ao deletar treino.";
    }
    $stmt->close();
}

// READ - Listar todos os treinos
$result = $conn->query("SELECT id, grupo, titulo, exercicios, created_at FROM treinos ORDER BY created_at DESC");
$treinos = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Treinos - Academia</title>
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
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
            font-family: 'Lexend', sans-serif;
        }
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
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
        .treinos-list {
            margin-top: 30px;
        }
        .treino-card {
            background: #f9f9f9;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            border-left: 4px solid #ec1313;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .treino-info {
            flex: 1;
        }
        .treino-info h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .treino-info p {
            margin: 5px 0;
            color: #666;
            font-size: 0.9rem;
        }
        .treino-actions {
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
        .exercicios-input {
            display: none;
        }
        .exercicios-input.active {
            display: block;
        }
    </style>
    <script src="theme-toggle.js"></script>
</head>
<body>
    <div class="container">
        <a href="perfil.php" class="back-btn">← Voltar</a>
        <h1>💪 Gerenciar Treinos</h1>

        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-success"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <?php if (!empty($erro)): ?>
            <div class="alert alert-error"><?php echo $erro; ?></div>
        <?php endif; ?>

        <!-- Formulário para adicionar treino -->
        <div class="form-section">
            <h2>Adicionar Novo Treino</h2>
            <form method="POST">
                <input type="hidden" name="acao" value="criar">
                
                <div class="form-group">
                    <label for="grupo">Grupo Muscular *</label>
                    <select id="grupo" name="grupo" required>
                        <option value="">Selecione um grupo</option>
                        <option value="triceps">Tríceps</option>
                        <option value="costas">Costas</option>
                        <option value="peito">Peito</option>
                        <option value="pernas">Pernas</option>
                        <option value="ombro">Ombro</option>
                        <option value="biceps">Bíceps</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="titulo">Título do Treino *</label>
                    <input type="text" id="titulo" name="titulo" required placeholder="Ex: Treino de Força para Tríceps">
                </div>

                <div class="form-group">
                    <label for="exercicios">Exercícios (um por linha)</label>
                    <textarea id="exercicios" name="exercicios[]" rows="5" placeholder="Rosca Francesa&#10;Tríceps na Polia&#10;Mergulho no Banco"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Adicionar Treino</button>
            </form>
        </div>

        <!-- Lista de treinos -->
        <div class="treinos-list">
            <h2>Treinos Cadastrados (<?php echo count($treinos); ?>)</h2>
            
            <?php if (empty($treinos)): ?>
                <p style="text-align: center; color: #999;">Nenhum treino cadastrado ainda.</p>
            <?php else: ?>
                <?php foreach ($treinos as $treino): 
                    $exercicios = json_decode($treino['exercicios'], true) ?? [];
                ?>
                    <div class="treino-card">
                        <div class="treino-info">
                            <h3><?php echo htmlspecialchars($treino['titulo']); ?></h3>
                            <p><strong>Grupo:</strong> <?php echo htmlspecialchars($treino['grupo']); ?></p>
                            <p><strong>Exercícios:</strong> <?php echo count($exercicios) > 0 ? implode(', ', $exercicios) : 'Nenhum'; ?></p>
                            <p><strong>Data:</strong> <?php echo date('d/m/Y H:i', strtotime($treino['created_at'])); ?></p>
                        </div>
                        <div class="treino-actions">
                            <a href="editar_treino.php?id=<?php echo $treino['id']; ?>" class="btn btn-secondary">Editar</a>
                            <a href="?deletar=<?php echo $treino['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja deletar este treino?');">Deletar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
