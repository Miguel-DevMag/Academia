<?php
/**
 * editar_treino.php - Editar um treino existente
 */

require_once 'auth_config.php';
requireLogin('login.php');

$conn = getDbConnection();
$mensagem = "";
$erro = "";
$treino = null;

// Obter ID do treino
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id === 0) {
    header("Location: admin_treinos.php");
    exit;
}

// READ - Obter dados do treino
$stmt = $conn->prepare("SELECT id, grupo, titulo, exercicios FROM treinos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: admin_treinos.php");
    exit;
}

$treino = $result->fetch_assoc();
$treino['exercicios'] = json_decode($treino['exercicios'], true) ?? [];
$stmt->close();

// UPDATE - Atualizar treino
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $grupo = trim($_POST['grupo'] ?? '');
    $titulo = trim($_POST['titulo'] ?? '');
    $exercicios_array = array_filter(array_map('trim', $_POST['exercicios'] ?? []), fn($x) => !empty($x));
    $exercicios = json_encode($exercicios_array);
    
    if (empty($grupo) || empty($titulo)) {
        $erro = "Grupo muscular e título são obrigatórios.";
    } else {
        $stmt = $conn->prepare("UPDATE treinos SET grupo = ?, titulo = ?, exercicios = ? WHERE id = ?");
        $stmt->bind_param("sssi", $grupo, $titulo, $exercicios, $id);
        
        if ($stmt->execute()) {
            $mensagem = "✅ Treino atualizado com sucesso!";
            $treino['grupo'] = $grupo;
            $treino['titulo'] = $titulo;
            $treino['exercicios'] = $exercicios_array;
        } else {
            $erro = "Erro ao atualizar treino: " . $stmt->error;
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
    <title>Editar Treino - Academia</title>
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
        .exercicio-item {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }
        .exercicio-item input {
            flex: 1;
        }
        .exercicio-item button {
            padding: 10px 15px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .exercicio-item button:hover {
            background: #c82333;
        }
        .add-exercicio-btn {
            background: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .add-exercicio-btn:hover {
            background: #218838;
        }
    </style>
    <script src="theme-toggle.js"></script>
</head>
<body>
    <div class="container">
        <a href="admin_treinos.php" class="back-btn">← Voltar</a>
        <h1>✏️ Editar Treino</h1>

        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-success"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <?php if (!empty($erro)): ?>
            <div class="alert alert-error"><?php echo $erro; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="grupo">Grupo Muscular *</label>
                <select id="grupo" name="grupo" required>
                    <option value="">Selecione um grupo</option>
                    <option value="triceps" <?php echo $treino['grupo'] === 'triceps' ? 'selected' : ''; ?>>Tríceps</option>
                    <option value="costas" <?php echo $treino['grupo'] === 'costas' ? 'selected' : ''; ?>>Costas</option>
                    <option value="peito" <?php echo $treino['grupo'] === 'peito' ? 'selected' : ''; ?>>Peito</option>
                    <option value="pernas" <?php echo $treino['grupo'] === 'pernas' ? 'selected' : ''; ?>>Pernas</option>
                    <option value="ombro" <?php echo $treino['grupo'] === 'ombro' ? 'selected' : ''; ?>>Ombro</option>
                    <option value="biceps" <?php echo $treino['grupo'] === 'biceps' ? 'selected' : ''; ?>>Bíceps</option>
                </select>
            </div>

            <div class="form-group">
                <label for="titulo">Título do Treino *</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($treino['titulo']); ?>" required>
            </div>

            <div class="form-group">
                <label>Exercícios</label>
                <div id="exercicios-container">
                    <?php foreach ($treino['exercicios'] as $exercicio): ?>
                        <div class="exercicio-item">
                            <input type="text" name="exercicios[]" value="<?php echo htmlspecialchars($exercicio); ?>" placeholder="Nome do exercício">
                            <button type="button" onclick="this.parentElement.remove();">Remover</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="add-exercicio-btn" onclick="adicionarExercicio();">+ Adicionar Exercício</button>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="admin_treinos.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        function adicionarExercicio() {
            const container = document.getElementById('exercicios-container');
            const exercicioItem = document.createElement('div');
            exercicioItem.className = 'exercicio-item';
            exercicioItem.innerHTML = `
                <input type="text" name="exercicios[]" placeholder="Nome do exercício">
                <button type="button" onclick="this.parentElement.remove();">Remover</button>
            `;
            container.appendChild(exercicioItem);
        }
    </script>
</body>
</html>
