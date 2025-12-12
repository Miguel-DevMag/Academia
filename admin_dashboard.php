<?php require_once 'header.php'; ?>

<div class="container max-w-6xl mx-auto py-6">
  <header class="text-center mb-8">
    <h1 class="text-4xl font-bold">🏋️ Academia Dashboard</h1>
    <p class="text-gray-600">Sistema Completo de Gerenciamento</p>
  </header>

  <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
    <a href="admin_videos.php" class="card bg-white p-6 rounded shadow hover:shadow-lg flex flex-col">
      <div class="text-4xl">📹</div>
      <h2 class="font-bold text-xl mt-2">Gerenciar Vídeos</h2>
      <p class="flex-grow text-gray-600 mt-2">Adicione, edite ou delete vídeos de treino.</p>
      <span class="mt-4 inline-block bg-blue-600 text-white px-3 py-1 rounded">Acessar</span>
    </a>

    <a href="admin_treinos.php" class="card bg-white p-6 rounded shadow hover:shadow-lg flex flex-col">
      <div class="text-4xl">💪</div>
      <h2 class="font-bold text-xl mt-2">Gerenciar Treinos</h2>
      <p class="flex-grow text-gray-600 mt-2">Crie programas de treino por grupo muscular.</p>
      <span class="mt-4 inline-block bg-purple-600 text-white px-3 py-1 rounded">Acessar</span>
    </a>

    <a href="admin_suplementos.php" class="card bg-white p-6 rounded shadow hover:shadow-lg flex flex-col">
      <div class="text-4xl">💊</div>
      <h2 class="font-bold text-xl mt-2">Gerenciar Suplementos</h2>
      <p class="flex-grow text-gray-600 mt-2">Adicione produtos nutricionais com preços.</p>
      <span class="mt-4 inline-block bg-pink-600 text-white px-3 py-1 rounded">Acessar</span>
    </a>

    <a href="admin_anabolizantes.php" class="card bg-white p-6 rounded shadow hover:shadow-lg flex flex-col">
      <div class="text-4xl">⚠️</div>
      <h2 class="font-bold text-xl mt-2">Gerenciar Anabolizantes</h2>
      <p class="flex-grow text-gray-600 mt-2">Informações sobre substâncias com alertas de saúde.</p>
      <span class="mt-4 inline-block bg-red-600 text-white px-3 py-1 rounded">Acessar</span>
    </a>

    <a href="admin_depoimentos.php" class="card bg-white p-6 rounded shadow hover:shadow-lg flex flex-col">
      <div class="text-4xl">⭐</div>
      <h2 class="font-bold text-xl mt-2">Gerenciar Depoimentos</h2>
      <p class="flex-grow text-gray-600 mt-2">Adicione histórias de sucesso e transformações.</p>
      <span class="mt-4 inline-block bg-orange-600 text-white px-3 py-1 rounded">Acessar</span>
    </a>

    <a href="admin_contatos.php" class="card bg-white p-6 rounded shadow hover:shadow-lg flex flex-col">
      <div class="text-4xl">📧</div>
      <h2 class="font-bold text-xl mt-2">Ver Mensagens</h2>
      <p class="flex-grow text-gray-600 mt-2">Visualize e responda mensagens de contato dos usuários.</p>
      <span class="mt-4 inline-block bg-green-600 text-white px-3 py-1 rounded">Acessar</span>
    </a>
  </div>

  <div class="status-section bg-white rounded p-6 mt-8 shadow">
    <h2 class="font-bold text-2xl mb-4">📊 Status do Sistema</h2>
    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
      <div class="status-item p-4 bg-gray-50 rounded border-l-4 border-blue-600">
        <h3 class="font-semibold">Autenticação <span class="status-badge bg-green-600 text-white px-2 rounded">OK</span></h3>
        <p class="text-gray-600">Login, registro e sessões funcionando</p>
      </div>
      <div class="status-item p-4 bg-gray-50 rounded border-l-4 border-blue-600">
        <h3 class="font-semibold">Banco de Dados <span class="status-badge bg-green-600 text-white px-2 rounded">OK</span></h3>
        <p class="text-gray-600">7 tabelas criadas e operacionais</p>
      </div>
      <div class="status-item p-4 bg-gray-50 rounded border-l-4 border-blue-600">
        <h3 class="font-semibold">CRUDs Implementados <span class="status-badge bg-green-600 text-white px-2 rounded">OK</span></h3>
        <p class="text-gray-600">Gerenciadores completos</p>
      </div>
    </div>
  </div>

  <div class="quick-links bg-white rounded p-6 mt-8 shadow">
    <h2 class="font-bold text-2xl mb-4">🔗 Links Rápidos</h2>
    <div class="grid gap-3 grid-cols-1 md:grid-cols-3">
      <a href="index.php" class="quick-link bg-blue-700 text-white py-2 px-3 rounded text-center">🏠 Página Inicial</a>
      <a href="contato.php" class="quick-link bg-blue-700 text-white py-2 px-3 rounded text-center">📧 Formulário de Contato</a>
      <a href="perfil.php" class="quick-link bg-blue-700 text-white py-2 px-3 rounded text-center">👤 Meu Perfil</a>
      <a href="teste_funcionalidades.php" class="quick-link bg-blue-700 text-white py-2 px-3 rounded text-center">🧪 Testar Sistema</a>
      <a href="logout.php" class="quick-link bg-blue-700 text-white py-2 px-3 rounded text-center">🚪 Logout</a>
    </div>
  </div>

</div>

<?php require_once 'footer.php'; ?>