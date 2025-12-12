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
        
        <div style="margin-top: 40px; padding-top: 30px; border-top: 2px solid #ddd;">
            <h2 style="color: #333; margin-bottom: 20px;">🎛️ Gerenciar Conteúdo</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 30px;">
                <a href="admin_videos.php" style="display: block; padding: 20px; background: #e3f2fd; border-radius: 8px; text-decoration: none; border-left: 4px solid #2196f3; transition: 0.3s;">
                    <strong style="color: #1976d2; font-size: 16px;">📹 Gerenciar Vídeos</strong>
                    <p style="color: #666; margin: 8px 0 0 0; font-size: 14px;">Adicionar, editar ou deletar vídeos</p>
                </a>
                
                <a href="admin_treinos.php" style="display: block; padding: 20px; background: #f3e5f5; border-radius: 8px; text-decoration: none; border-left: 4px solid #9c27b0; transition: 0.3s;">
                    <strong style="color: #7b1fa2; font-size: 16px;">💪 Gerenciar Treinos</strong>
                    <p style="color: #666; margin: 8px 0 0 0; font-size: 14px;">Cadastrar programas de treino</p>
                </a>
                
                <a href="admin_suplementos.php" style="display: block; padding: 20px; background: #fce4ec; border-radius: 8px; text-decoration: none; border-left: 4px solid #e91e63; transition: 0.3s;">
                    <strong style="color: #c2185b; font-size: 16px;">💊 Gerenciar Suplementos</strong>
                    <p style="color: #666; margin: 8px 0 0 0; font-size: 14px;">Adicionar produtos e preços</p>
                </a>
                
                <a href="admin_anabolizantes.php" style="display: block; padding: 20px; background: #ffebee; border-radius: 8px; text-decoration: none; border-left: 4px solid #f44336; transition: 0.3s;">
                    <strong style="color: #d32f2f; font-size: 16px;">⚠️ Gerenciar Anabolizantes</strong>
                    <p style="color: #666; margin: 8px 0 0 0; font-size: 14px;">Informações e alertas de saúde</p>
                </a>
                
                <a href="admin_depoimentos.php" style="display: block; padding: 20px; background: #fff3e0; border-radius: 8px; text-decoration: none; border-left: 4px solid #ff9800; transition: 0.3s;">
                    <strong style="color: #e65100; font-size: 16px;">⭐ Gerenciar Depoimentos</strong>
                    <p style="color: #666; margin: 8px 0 0 0; font-size: 14px;">Adicionar histórias de sucesso</p>
                </a>
                
                <a href="admin_contatos.php" style="display: block; padding: 20px; background: #e8f5e9; border-radius: 8px; text-decoration: none; border-left: 4px solid #4caf50; transition: 0.3s;">
                    <strong style="color: #2e7d32; font-size: 16px;">📧 Ver Mensagens</strong>
                    <p style="color: #666; margin: 8px 0 0 0; font-size: 14px;">Mensagens de contato dos usuários</p>
                </a>
            </div>
        </div>
        
        <div class="button-group">
            <a href="index.html" class="btn-back">← Home</a>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </div>
</body>
</html>
