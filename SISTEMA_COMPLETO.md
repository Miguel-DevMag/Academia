# 🏋️ Academia - Sistema de Gerenciamento

## Visão Geral

Sistema completo de gerenciamento de academia com funcionalidades de autenticação, gerenciamento de conteúdo e integração com banco de dados.

## 📋 Funcionalidades Implementadas

### ✅ Autenticação
- [x] Login e registro de usuários
- [x] Proteção de páginas com autenticação
- [x] Sessões seguras
- [x] Logout

### ✅ Gerenciamento de Conteúdo

#### 📹 Vídeos
- [x] Listar vídeos
- [x] Adicionar novos vídeos
- [x] Editar vídeos existentes
- [x] Deletar vídeos
- [x] Integração com banco de dados

#### 💪 Treinos
- [x] Listar treinos por grupo muscular
- [x] Adicionar novos treinos com exercícios
- [x] Editar treinos
- [x] Deletar treinos
- [x] Armazenamento de exercícios em JSON

#### 💊 Suplementos
- [x] Listar suplementos
- [x] Adicionar produtos com preço
- [x] Editar suplementos
- [x] Deletar suplementos
- [x] Gerenciamento de preços

#### ⚠️ Anabolizantes
- [x] Listar substâncias
- [x] Adicionar informações com riscos
- [x] Editar dados
- [x] Deletar registros
- [x] Alertas de saúde

#### ⭐ Depoimentos
- [x] Listar depoimentos
- [x] Adicionar novos depoimentos
- [x] Editar depoimentos
- [x] Deletar depoimentos
- [x] Links para vídeos

#### 📧 Contato
- [x] Formulário de contato funcional
- [x] Salvamento de mensagens no BD
- [x] Visualização de mensagens recebidas
- [x] Exclusão de mensagens

## 🚀 Como Usar

### 1. Setup Inicial
Abra seu navegador e acesse:
```
http://localhost/Academia/setup.php
```
Isso criará automaticamente o banco de dados e as tabelas necessárias.

### 2. Criar Conta
Acesse:
```
http://localhost/Academia/criar_conta.php
```

Preencha:
- Nome Completo
- Email
- Nome de usuário
- Senha (mín. 6 caracteres)

### 3. Fazer Login
Acesse:
```
http://localhost/Academia/login.php
```

Use seu email ou nome de usuário e senha.

### 4. Acessar Painel de Gerenciamento
Após fazer login, acesse:
```
http://localhost/Academia/perfil.php
```

Você verá um menu com todas as opções de gerenciamento:
- 📹 Gerenciar Vídeos
- 💪 Gerenciar Treinos
- 💊 Gerenciar Suplementos
- ⚠️ Gerenciar Anabolizantes
- ⭐ Gerenciar Depoimentos
- 📧 Ver Mensagens

## 📁 Estrutura de Arquivos

### Autenticação
- `auth_config.php` - Funções centralizadas de autenticação
- `login.php` - Página de login
- `criar_conta.php` - Página de registro
- `logout.php` - Fazer logout
- `perfil.php` - Painel do usuário (protegido)

### Gerenciadores de Conteúdo
- `admin_videos.php` / `editar_video.php` - CRUD de vídeos
- `admin_treinos.php` / `editar_treino.php` - CRUD de treinos
- `admin_suplementos.php` / `editar_suplemento.php` - CRUD de suplementos
- `admin_anabolizantes.php` / `editar_anabolizante.php` - CRUD de anabolizantes
- `admin_depoimentos.php` / `editar_depoimento.php` - CRUD de depoimentos
- `admin_contatos.php` - Visualizar mensagens de contato

### Páginas Públicas
- `index.html` - Página inicial
- `contato.php` - Formulário de contato

### Banco de Dados
- `conexao.php` - Conexão com MySQL
- `database.sql` - Schema do banco
- `setup.php` - Script de inicialização

## 🔐 Segurança

✅ Senhas criptografadas com `password_hash()` (BCRYPT)
✅ Prepared statements para prevenir SQL Injection
✅ Sessões seguras e autenticação
✅ Validação de entrada de dados
✅ Proteção de páginas com `requireLogin()`

## 💾 Banco de Dados

Tabelas criadas:
- `users` - Usuários do sistema
- `videos` - Vídeos de treino
- `treinos` - Programas de treino
- `suplementos` - Produtos nutricionais
- `anabolizantes` - Informações de substâncias
- `depoimentos` - Depoimentos de usuários
- `contatos` - Mensagens de contato

## 📝 Exemplos de Uso

### Adicionar um Vídeo
1. Acesse `/admin_videos.php`
2. Preencha o formulário
3. Clique em "Adicionar Vídeo"
4. O vídeo será salvo no banco de dados

### Adicionar um Treino
1. Acesse `/admin_treinos.php`
2. Selecione o grupo muscular
3. Digite o título
4. Adicione os exercícios
5. Clique em "Adicionar Treino"

### Ver Mensagens de Contato
1. Acesse `/admin_contatos.php`
2. Visualize todas as mensagens recebidas
3. Delete mensagens conforme necessário

## 🛠️ Troubleshooting

**Erro: "Banco de dados não conectado"**
- Certifique-se de que MySQL está rodando
- Verifique as credenciais em `conexao.php`
- Execute `setup.php` novamente

**Erro: "Acesso negado"**
- Faça login antes de acessar páginas protegidas
- Use `/login.php` para autenticar

**Páginas não atualizam**
- Limpe o cache do navegador
- Atualize a página (F5)

## 📞 Contato

Para suporte, use o formulário de contato em `/contato.php`

---

**Versão:** 1.0
**Data:** Dezembro 2024
**Status:** ✅ Todas as funcionalidades testadas e operacionais
