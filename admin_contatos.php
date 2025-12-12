<?php
/**
 * admin_contatos.php - Visualizar mensagens de contato
 */

require_once 'auth_config.php';
requireLogin('login.php');

$conn = getDbConnection();

// DELETE - Deletar mensagem
if (isset($_GET['deletar'])) {
    $id = intval($_GET['deletar']);
    $stmt = $conn->prepare("DELETE FROM contatos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_contatos.php");
    exit;
}

// READ - Listar todas as mensagens
$result = $conn->query("SELECT id, nome, email, mensagem, criado_em FROM contatos ORDER BY criado_em DESC");
$mensagens = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensagens de Contato - Academia</title>
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
        .message-card {
            background: #f9f9f9;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            border-left: 4px solid #ec1313;
        }
        .message-card h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .message-card p {
            margin: 5px 0;
            color: #666;
            font-size: 0.9rem;
        }
        .message-text {
            background: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            border-left: 3px solid #007bff;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
        }
        .btn-danger:hover {
            background: #c82333;
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
        .count {
            background: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
        }
        h1 .count {
            margin-left: 10px;
        }
    </style>
    <script src="theme-toggle.js"></script>
</head>
<body>
    <div class="container">
        <a href="perfil.php" class="back-btn">← Voltar</a>
        <h1>📧 Mensagens de Contato <span class="count"><?php echo count($mensagens); ?></span></h1>

        <?php if (empty($mensagens)): ?>
            <p style="text-align: center; color: #999; font-size: 18px; margin-top: 40px;">Nenhuma mensagem recebida ainda.</p>
        <?php else: ?>
            <?php foreach ($mensagens as $msg): ?>
                <div class="message-card">
                    <h3>De: <?php echo htmlspecialchars($msg['nome']); ?></h3>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($msg['email']); ?></p>
                    <p><strong>Data:</strong> <?php echo date('d/m/Y H:i', strtotime($msg['criado_em'])); ?></p>
                    
                    <div class="message-text">
                        <?php echo htmlspecialchars($msg['mensagem']); ?>
                    </div>
                    
                    <a href="?deletar=<?php echo $msg['id']; ?>" class="btn-danger" onclick="return confirm('Tem certeza que deseja deletar esta mensagem?');">Deletar</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
