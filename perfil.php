<?php
/**
 * perfil.php - Página do usuário logado (exemplo de página protegida)
 */

require_once 'auth_config.php';
requireLogin('login.php');

$user = getLoggedUser();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - Academia</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { background: linear-gradient(135deg, #001f3f, #003366); min-height: 100vh; padding: 20px; }
        .profile-container { max-width: 600px; margin: 50px auto; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.3); }
        .profile-container h1 { color: #333; text-align: center; margin-bottom: 30px; }
        .profile-info { margin: 20px 0; padding: 15px; background: #f9f9f9; border-left: 4px solid #ec1313; border-radius: 5px; }
        .profile-info label { font-weight: bold; color: #555; display: block; margin-bottom: 5px; }
        .profile-info span { color: #333; font-size: 1.1rem; }
        .btn-logout { display: inline-block; padding: 12px 30px; background: #dc3545; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 20px; }
        .btn-logout:hover { background: #c82333; }
        .btn-back { display: inline-block; padding: 12px 30px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; margin-right: 10px; }
        .btn-back:hover { background: #0056b3; }
        .button-group { text-align: center; }
    </style>
    <script src="theme-toggle.js"></script>
</head>
<body>
    <div class="profile-container">
        <h1>👤 Meu Perfil</h1>
        
        <div class="profile-info">
            <label>Nome:</label>
            <span><?php echo htmlspecialchars($user['nome']); ?></span>
        </div>
        
        <div class="profile-info">
            <label>Email:</label>
            <span><?php echo htmlspecialchars($user['email']); ?></span>
        </div>
        
        <div class="profile-info">
            <label>Usuário:</label>
            <span><?php echo htmlspecialchars($user['usuario']); ?></span>
        </div>
        
        <div class="profile-info">
            <label>ID:</label>
            <span><?php echo $user['id']; ?></span>
        </div>
        
        <div class="button-group">
            <a href="index.html" class="btn-back">← Voltar</a>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </div>
</body>
</html>
