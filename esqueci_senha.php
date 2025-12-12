<?php require_once 'header.php'; ?>

<div class="max-w-md mx-auto p-6 bg-white rounded">
  <h1 class="text-xl font-bold mb-4">Recuperar Senha</h1>
  <form method="POST" action="esqueci_senha.php" class="space-y-4">
    <input type="email" name="email" placeholder="Seu email" required class="w-full p-3 border rounded" />
    <button type="submit" class="btn-login w-full">Enviar link de recuperação</button>
  </form>
</div>

<?php require_once 'footer.php'; ?>