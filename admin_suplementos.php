<?php
/**
 * admin_suplementos.php - Versão com Acessibilidade Centralizada
 */

require_once 'auth_config.php';
requireLogin('login.php');

$conn = getDbConnection();
$mensagem = "";
$erro = "";

// Lógica de Banco de Dados (Mantida)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'criar') {
    $nome = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = isset($_POST['preco']) && !empty($_POST['preco']) ? floatval($_POST['preco']) : NULL;
    
    if (!empty($nome)) {
        $stmt = $conn->prepare("INSERT INTO suplementos (nome, descricao, preco) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $nome, $descricao, $preco);
        if ($stmt->execute()) { $mensagem = "✅ Suplemento adicionado!"; }
        $stmt->close();
    }
}

if (isset($_GET['deletar'])) {
    $id = intval($_GET['deletar']);
    $conn->query("DELETE FROM suplementos WHERE id = $id");
    $mensagem = "✅ Deletado com sucesso!";
}

$result = $conn->query("SELECT * FROM suplementos ORDER BY criado_em DESC");
$suplementos = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Suplementos - Academia</title>
    <style>
        body {
            margin: 0;
            font-family: 'Lexend', sans-serif;
            background-color: #0d0d0d;
            color: white;
        }

        /* --- BARRA DE ACESSIBILIDADE CENTRALIZADA --- */
        .barra-acessibilidade {
            background-color: #1a1515; /* Tom escuro da imagem */
            padding: 10px 0;
            display: flex;
            justify-content: center; /* Centraliza horizontalmente */
            align-items: center;     /* Alinha verticalmente */
            gap: 10px;               /* Espaço entre os botões */
            border-bottom: 1px solid #333;
        }

        .acess-label {
            font-size: 12px;
            font-weight: bold;
            color: #888;
            text-transform: uppercase;
            margin-right: 10px;
        }

        .btn-acess {
            background: transparent;
            color: white;
            border: 1px solid #444;
            padding: 5px 15px;
            border-radius: 4px;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-acess:hover {
            background: #f26508;
            border-color: #f26508;
        }

        /* --- HEADER --- */
        .header-main {
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo { font-size: 24px; font-weight: bold; }

        .btn-conta {
            border: 1px solid white;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            margin-right: 10px;
        }

        .btn-agende {
            background-color: #ff0000; /* Vermelho da imagem */
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }

        /* --- CONTEÚDO --- */
        .main-content {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
        }

        .form-box {
            background: #151515;
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #222;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            margin-bottom: 15px;
            background: #222;
            border: 1px solid #333;
            color: white;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .btn-add {
            background: #f26508;
            color: white;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .card {
            background: #151515;
            padding: 15px;
            margin-top: 15px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 4px solid #f26508;
        }
    </style>
</head>
<body>

    <div class="barra-acessibilidade">
        <span class="acess-label">Acessibilidade:</span>
        <button class="btn-acess">Aumentar</button>
        <button class="btn-acess">Diminuir</button>
        <button class="btn-acess">Padrão</button>
        <button class="btn-acess">Contraste</button>
        <button class="btn-acess">Ouvir</button>
    </div>

    <header class="header-main">
        <div class="logo">Academia</div>
        <div>
            <a href="#" class="btn-conta">Acesse/Crie sua conta</a>
            <a href="#" class="btn-agende">Agende sua Aula</a>
        </div>
    </header>

    <div class="main-content">
        <?php if($mensagem) echo "<p style='color:#4ade80'>$mensagem</p>"; ?>

        <div class="form-box">
            <h3>Novo Suplemento</h3>
            <form method="POST">
                <input type="hidden" name="acao" value="criar">
                <label>Nome</label>
                <input type="text" name="nome" required>
                <label>Preço</label>
                <input type="number" name="preco" step="0.01">
                <button type="submit" class="btn-add">SALVAR PRODUTO</button>
            </form>
        </div>

        <h3 style="margin-top:40px;">Lista de Produtos</h3>
        <?php foreach ($suplementos as $s): ?>
            <div class="card">
                <div>
                    <strong><?php echo htmlspecialchars($s['nome']); ?></strong><br>
                    <small>R$ <?php echo number_format($s['preco'], 2, ',', '.'); ?></small>
                </div>
                <div>
                    <a href="?deletar=<?php echo $s['id']; ?>" style="color:#ff4d4d; text-decoration:none;">Excluir</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>