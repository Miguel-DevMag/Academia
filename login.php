<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (!empty($email) && !empty($senha)) {
        $sql = "SELECT * FROM users WHERE email = ? OR usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $email, $email); // Verifica tanto por email quanto por usuário
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verifica a senha usando MD5
            if ($user['senha_hash'] === md5($senha)) {
                $_SESSION['usuario_id'] = $user['id'];
                $_SESSION['usuario_nome'] = $user['nome'];
                $_SESSION['usuario_email'] = $user['email'];
                $_SESSION['usuario_username'] = $user['usuario'];

                // Redireciona para a página principal
                $redirect = $_SESSION['redirect_after_login'] ?? 'index.html';
                unset($_SESSION['redirect_after_login']);

                header("Location: " . $redirect);
                exit;
            } else {
                $erro = "Senha incorreta.";
            }
        } else {
            $erro = "Usuário ou email não encontrado.";
        }

        $stmt->close();
        $conn->close();
    } else {
        $erro = "Por favor, preencha todos os campos.";
    }
}