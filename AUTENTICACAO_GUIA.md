<!-- 
  GUIA DE USO DO SISTEMA DE AUTENTICAÇÃO
  Academia - Login & Registro
-->

## 🚀 Como Usar o Sistema de Autenticação

### 1️⃣ SETUP INICIAL (Executar uma única vez)
Abra no navegador:
```
http://localhost/Academia/setup.php
```
Isso criará automaticamente:
- Banco de dados `academia`
- Tabelas: users, depoimentos, videos, suplementos, treinos, anabolizantes, contatos
- Dados iniciais (3 vídeos de exemplo)

### 2️⃣ CRIAR UMA CONTA
1. Acesse: `http://localhost/Academia/criar_conta.php`
2. Preencha:
   - Nome Completo
   - Email
   - Nome de Usuário (mín. 3 caracteres)
   - Senha (mín. 6 caracteres)
   - Confirmar Senha
3. Clique em "Criar Conta"

### 3️⃣ FAZER LOGIN
1. Acesse: `http://localhost/Academia/login.php`
2. Use:
   - Usuário: nome de usuário OU email
   - Senha: a senha cadastrada
3. Clique em "Entrar"

### 4️⃣ VER PERFIL (Quando Logado)
Acesse: `http://localhost/Academia/perfil.php`
Você verá:
- Nome
- Email
- Usuário
- ID

### 5️⃣ FAZER LOGOUT
Na página `/perfil.php`, clique em "Logout"
Ou acesse direto: `http://localhost/Academia/logout.php`

---

## 📁 ARQUIVOS CRIADOS/MODIFICADOS

### Novos Arquivos:
- `setup.php` - Cria BD e tabelas (execute uma vez)
- `auth_config.php` - Funções centralizadas de autenticação
- `login.php` - Página de login com validação
- `register.php` - Página de registro (antiga: register.html)
- `criar_conta.php` - Alternativa de registro (convertida de HTML)
- `logout.php` - Faz logout
- `perfil.php` - Página protegida (exemplo)

### Modificados:
- `conexao.php` - Melhorado para criar BD se não existir
- `index.html` - Links atualizados
- `login.html` - Form action → login.php
- `barra_acesessibilidade.php` - Adicionados links para login/perfil

---

## 🔐 SEGURANÇA

✅ **Senhas:** Usando `password_hash()` com BCRYPT
✅ **SQL Injection:** Usando prepared statements
✅ **Sessões:** Armazenadas em $_SESSION
✅ **Validação:** Email, tamanho de senha, confirmação

---

## 💡 EXEMPLO DE USO REAL

1. Usuário acessa: `login.php`
2. Tenta acessar: `perfil.php` ANTES de logar
3. Sistema redireciona para: `login.php?redirect=/perfil.php`
4. Após login bem-sucedido, redireciona de volta para: `perfil.php`

---

## 🛠️ PARA PROTEGER SUAS PÁGINAS

Adicione no início de qualquer PHP:
```php
<?php
require_once 'auth_config.php';
requireLogin('login.php'); // redireciona se não estiver logado
$user = getLoggedUser(); // pega dados do usuário
?>
```

---

## 📊 ESTRUTURA DO BANCO

### Tabela: users
```
id (INT, PK)
nome (VARCHAR)
email (VARCHAR, UNIQUE)
usuario (VARCHAR, UNIQUE)
senha_hash (VARCHAR)
created_at (TIMESTAMP)
```

---

Pronto para usar! 🎉
