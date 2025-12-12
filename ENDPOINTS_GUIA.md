# 📋 Guia Completo de Endpoints - Academia

## 🔐 Autenticação

| Funcionalidade | URL | Método | Descrição |
|---|---|---|---|
| Setup Inicial | `/setup.php` | GET | Cria BD e tabelas |
| Login | `/login.php` | POST | Autentica usuário |
| Registro | `/criar_conta.php` | POST | Cria nova conta |
| Logout | `/logout.php` | GET | Encerra sessão |
| Perfil | `/perfil.php` | GET | Painel do usuário (protegido) |

## 📹 Vídeos

| Funcionalidade | URL | Método | Descrição |
|---|---|---|---|
| Listar | `/admin_videos.php` | GET | Exibe todos os vídeos |
| Adicionar | `/admin_videos.php` | POST | Cria novo vídeo |
| Editar | `/editar_video.php?id=X` | GET/POST | Edita vídeo específico |
| Deletar | `/admin_videos.php?deletar=X` | GET | Remove vídeo |

**Parâmetros POST (Adicionar/Editar):**
```php
$_POST['acao'] = 'criar';
$_POST['titulo'] = 'Nome do vídeo';
$_POST['descricao'] = 'Descrição...';
$_POST['src'] = 'videos/arquivo.mp4';
```

## 💪 Treinos

| Funcionalidade | URL | Método | Descrição |
|---|---|---|---|
| Listar | `/admin_treinos.php` | GET | Exibe todos os treinos |
| Adicionar | `/admin_treinos.php` | POST | Cria novo treino |
| Editar | `/editar_treino.php?id=X` | GET/POST | Edita treino específico |
| Deletar | `/admin_treinos.php?deletar=X` | GET | Remove treino |

**Parâmetros POST (Adicionar/Editar):**
```php
$_POST['acao'] = 'criar';
$_POST['grupo'] = 'triceps|costas|peito|pernas|ombro|biceps';
$_POST['titulo'] = 'Nome do treino';
$_POST['exercicios'][] = 'Exercício 1';
$_POST['exercicios'][] = 'Exercício 2';
```

## 💊 Suplementos

| Funcionalidade | URL | Método | Descrição |
|---|---|---|---|
| Listar | `/admin_suplementos.php` | GET | Exibe todos os suplementos |
| Adicionar | `/admin_suplementos.php` | POST | Cria novo suplemento |
| Editar | `/editar_suplemento.php?id=X` | GET/POST | Edita suplemento específico |
| Deletar | `/admin_suplementos.php?deletar=X` | GET | Remove suplemento |

**Parâmetros POST (Adicionar/Editar):**
```php
$_POST['acao'] = 'criar';
$_POST['nome'] = 'Nome do suplemento';
$_POST['descricao'] = 'Descrição...';
$_POST['preco'] = '99.90';
```

## ⚠️ Anabolizantes

| Funcionalidade | URL | Método | Descrição |
|---|---|---|---|
| Listar | `/admin_anabolizantes.php` | GET | Exibe todas as substâncias |
| Adicionar | `/admin_anabolizantes.php` | POST | Cria novo registro |
| Editar | `/editar_anabolizante.php?id=X` | GET/POST | Edita registro específico |
| Deletar | `/admin_anabolizantes.php?deletar=X` | GET | Remove registro |

**Parâmetros POST (Adicionar/Editar):**
```php
$_POST['acao'] = 'criar';
$_POST['codigo'] = 'DECA';
$_POST['nome'] = 'Decanoato de Nandrolona';
$_POST['risco'] = 'Descrição dos riscos...';
$_POST['descricao'] = 'Informações gerais...';
```

## ⭐ Depoimentos

| Funcionalidade | URL | Método | Descrição |
|---|---|---|---|
| Listar | `/admin_depoimentos.php` | GET | Exibe todos os depoimentos |
| Adicionar | `/admin_depoimentos.php` | POST | Cria novo depoimento |
| Editar | `/editar_depoimento.php?id=X` | GET/POST | Edita depoimento específico |
| Deletar | `/admin_depoimentos.php?deletar=X` | GET | Remove depoimento |

**Parâmetros POST (Adicionar/Editar):**
```php
$_POST['acao'] = 'criar';
$_POST['nome'] = 'Nome da pessoa';
$_POST['texto'] = 'Depoimento...';
$_POST['video_src'] = 'videos/depoimento.mp4'; // opcional
```

## 📧 Contato

| Funcionalidade | URL | Método | Descrição |
|---|---|---|---|
| Formulário | `/contato.php` | GET | Exibe formulário |
| Enviar | `/contato.php` | POST | Envia mensagem para BD |
| Visualizar | `/admin_contatos.php` | GET | Exibe mensagens (protegido) |
| Deletar | `/admin_contatos.php?deletar=X` | GET | Remove mensagem |

**Parâmetros POST (Enviar):**
```php
$_POST['nome'] = 'Nome completo';
$_POST['email'] = 'email@exemplo.com';
$_POST['assunto'] = 'Assunto da mensagem';
$_POST['mensagem'] = 'Conteúdo da mensagem...';
```

## 🛡️ Proteção de Páginas

As seguintes páginas requerem login (chamam `requireLogin()`):
- `/admin_videos.php`
- `/admin_treinos.php`
- `/admin_suplementos.php`
- `/admin_anabolizantes.php`
- `/admin_depoimentos.php`
- `/admin_contatos.php`
- `/editar_video.php`
- `/editar_treino.php`
- `/editar_suplemento.php`
- `/editar_anabolizante.php`
- `/editar_depoimento.php`
- `/perfil.php`

Se não estiver logado, será redirecionado para `/login.php`

## 🔍 Códigos de Resposta

| Código | Significado | Ação |
|---|---|---|
| 200 | OK | Operação bem-sucedida |
| 302 | Redirect | Redirecionado automaticamente |
| 400 | Bad Request | Dados inválidos |
| 401 | Unauthorized | Requer login |
| 404 | Not Found | Página/Recurso não encontrado |
| 500 | Server Error | Erro no servidor/BD |

## 💾 Banco de Dados

### Funções Disponíveis (auth_config.php)

```php
// Verificar se está logado
isLoggedIn(); // retorna bool

// Obter dados do usuário logado
$user = getLoggedUser(); // retorna array
// array('id', 'nome', 'email', 'usuario')

// Requerer login para acessar página
requireLogin('login.php'); // redireciona se não logado

// Conectar ao BD
$conn = getDbConnection(); // retorna mysqli connection
```

### Exemplos de Queries

**Listar todos os vídeos:**
```php
$result = $conn->query("SELECT id, titulo, descricao, src, created_at FROM videos ORDER BY created_at DESC");
$videos = $result->fetch_all(MYSQLI_ASSOC);
```

**Adicionar vídeo (seguro):**
```php
$stmt = $conn->prepare("INSERT INTO videos (titulo, descricao, src) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $titulo, $descricao, $src);
$stmt->execute();
$stmt->close();
```

**Atualizar vídeo:**
```php
$stmt = $conn->prepare("UPDATE videos SET titulo = ?, descricao = ?, src = ? WHERE id = ?");
$stmt->bind_param("sssi", $titulo, $descricao, $src, $id);
$stmt->execute();
$stmt->close();
```

**Deletar vídeo:**
```php
$stmt = $conn->prepare("DELETE FROM videos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
```

## 📊 Estrutura de Resposta JSON (Sugerida para API)

```json
{
  "status": "success",
  "message": "Operação realizada com sucesso",
  "data": {
    "id": 1,
    "titulo": "Treino de Perna",
    "descricao": "...",
    "created_at": "2024-12-12 10:30:00"
  }
}
```

## 🔗 Links Rápidos

- **Página Inicial:** `http://localhost/Academia/index.html`
- **Contato:** `http://localhost/Academia/contato.php`
- **Login:** `http://localhost/Academia/login.php`
- **Registro:** `http://localhost/Academia/criar_conta.php`
- **Perfil:** `http://localhost/Academia/perfil.php` (protegido)
- **Teste:** `http://localhost/Academia/teste_funcionalidades.php`

## 🚨 Troubleshooting

### "Acesso Negado"
- Você não está logado
- Use `/login.php` para autenticar

### "Banco de Dados não conectado"
- MySQL não está rodando
- Credenciais em `conexao.php` estão erradas
- Banco de dados não foi criado (execute `/setup.php`)

### "Erro ao salvar dados"
- Verifique validações de entrada
- Confira campos obrigatórios
- Verifique permissões do BD

### "Página em branco"
- Verifique logs do servidor
- Use `teste_funcionalidades.php`
- Limpe cache do navegador

---

**Documentação Versão:** 1.0
**Data:** Dezembro 2024
**Última Atualização:** Dezembro 12, 2024
