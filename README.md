# Academia - Sistema de Gestão para Academia de Fitness

## 📋 Descrição do Projeto

O **Academia** é um sistema web completo desenvolvido em PHP para gerenciar uma academia de fitness. O projeto oferece uma plataforma online onde usuários podem acessar informações sobre suplementos, treinos, vídeos educacionais, depoimentos de alunos, e muito mais. Inclui funcionalidades de autenticação de usuários, painéis administrativos para gerenciamento de conteúdo, e recursos de acessibilidade para uma experiência inclusiva.

O sistema é projetado para academias que desejam fornecer conteúdo educacional e informativo sobre fitness, nutrição, e atividades físicas, com ênfase em acessibilidade e usabilidade.

## 🎯 Para que Serve

- **Para Usuários Finais**: Acesso a informações sobre suplementos, treinos personalizados, vídeos de aulas, depoimentos de outros alunos, e contato com a academia.
- **Para Administradores**: Gerenciamento completo de conteúdo, incluindo adição/edição de suplementos, treinos, vídeos, depoimentos, anabolizantes, e mensagens de contato.
- **Para Academias**: Plataforma para promover serviços, aulas experimentais gratuitas, e engajar a comunidade fitness.
- **Inclusividade**: Recursos de acessibilidade como aumento/diminuição de fonte, modo escuro, text-to-speech, e suporte a Libras (VLibras).

## 🚀 Funcionalidades Principais

### Para Usuários
- **Página Inicial**: Vídeos promocionais, cards de navegação para seções principais.
- **Informações sobre Anabolizantes**: Detalhes sobre substâncias para performance, com códigos, nomes, riscos e descrições.
- **Suplementos**: Lista de produtos com nomes, descrições e preços.
- **Treinos**: Treinos organizados por grupos musculares, com exercícios em formato JSON.
- **Vídeos**: Biblioteca de vídeos educacionais (musculação adaptada, dança inclusiva, artes marciais).
- **Depoimentos**: Histórias reais de alunos.
- **Contato**: Formulário para enviar mensagens à academia.
- **Autenticação**: Registro, login, perfil pessoal e logout.
- **Aulas**: Páginas dedicadas para Treino, Dança e Lutas (artes marciais).

### Para Administradores
- **Painéis de Administração**: Interfaces para gerenciar cada tipo de conteúdo (suplementos, treinos, vídeos, etc.).
- **CRUD Completo**: Criar, ler, atualizar e deletar registros em todas as tabelas.
- **Dashboard**: Visão geral do sistema.

### Recursos Gerais
- **Acessibilidade**: Barra de acessibilidade com controles de fonte, contraste, modo escuro e text-to-speech.
- **Design Responsivo**: Compatível com dispositivos móveis e desktop, usando Tailwind CSS.
- **Modo Escuro**: Alternância automática ou manual entre temas claro e escuro.
- **Integração com VLibras**: Suporte para Libras (Língua Brasileira de Sinais).

## 🛠️ Tecnologias Utilizadas

- **Backend**: PHP 7+ com MySQL/MariaDB
- **Frontend**: HTML5, CSS3 (Tailwind CSS), JavaScript
- **Banco de Dados**: MySQL com tabelas para usuários, depoimentos, vídeos, suplementos, treinos, anabolizantes e contatos
- **Segurança**: Senhas hashadas com BCRYPT, prepared statements para prevenir SQL injection, sessões seguras
- **Acessibilidade**: VLibras, controles de fonte e contraste
- **Outros**: Fontes Google (Lexend), ícones Material Symbols

## 📦 Instalação e Configuração

### Pré-requisitos
- Servidor web (Apache/Nginx) com suporte a PHP
- MySQL ou MariaDB
- PHP 7.0 ou superior com extensões mysqli e pdo_mysql
- Navegador web moderno

### Passos de Instalação

1. **Clone ou Baixe o Repositório**:
   ```
   git clone https://github.com/seu-usuario/academia.git
   cd academia
   ```

2. **Configure o Banco de Dados**:
   - Certifique-se de que o MySQL está rodando.
   - Execute o script de setup acessando `http://localhost/Academia/setup.php` no navegador.
   - Isso criará automaticamente o banco `academia` e todas as tabelas necessárias, além de inserir dados iniciais.

3. **Configurações de Conexão**:
   - Edite `conexao.php` se necessário para ajustar credenciais do banco (padrão: localhost, root, senha vazia).

4. **Estrutura de Arquivos**:
   - Coloque os arquivos na raiz do servidor web (ex: `htdocs/Academia/`).
   - Certifique-se de que as pastas `videos/` e `imagens/` tenham permissões de escrita se necessário.

5. **Acesse a Aplicação**:
   - Página inicial: `http://localhost/Academia/index.html`
   - Setup inicial: `http://localhost/Academia/setup.php`

## 📖 Como Usar

### Para Novos Usuários
1. Acesse a página inicial e clique em "Acesse/Crie sua conta".
2. Registre-se em `criar_conta.php` ou `register.php` com nome, email, usuário e senha.
3. Faça login em `login.php`.
4. Explore as seções: Anabolizantes, Suplementos, Treinos, Vídeos, Depoimentos.
5. Use a barra de acessibilidade para ajustar fonte, contraste ou ativar text-to-speech.

### Para Administradores
1. Faça login como administrador (se configurado).
2. Acesse os painéis em `admin_*.php` (ex: `admin_suplementos.php`).
3. Adicione, edite ou remova conteúdo conforme necessário.
4. Gerencie mensagens de contato em `admin_contatos.php`.

### Protegendo Páginas
Para páginas que requerem login, adicione no topo do arquivo PHP:
```php
<?php
require_once 'auth_config.php';
requireLogin('login.php'); // Redireciona se não logado
$user = getLoggedUser(); // Obtém dados do usuário
?>
```

## 🗄️ Estrutura do Banco de Dados

O sistema utiliza as seguintes tabelas:

- **users**: Usuários registrados (id, nome, email, usuario, senha_hash, created_at)
- **depoimentos**: Depoimentos de alunos (id, nome, texto, video_src, created_at)
- **videos**: Metadados de vídeos (id, titulo, descricao, src, created_at)
- **suplementos**: Produtos suplementares (id, nome, descricao, preco, criado_em)
- **treinos**: Planos de treino (id, grupo, titulo, exercicios JSON, created_at)
- **anabolizantes**: Informações sobre anabolizantes (id, codigo, nome, risco, descricao, created_at)
- **contatos**: Mensagens de contato (id, nome, email, mensagem, criado_em)

## 🔒 Segurança

- Senhas armazenadas com hash BCRYPT.
- Uso de prepared statements para consultas SQL.
- Sessões PHP para gerenciamento de login.
- Validação de entrada de dados.
- Proteção contra SQL injection e XSS básico.

## 🤝 Contribuição

1. Fork o projeto.
2. Crie uma branch para sua feature (`git checkout -b feature/nova-feature`).
3. Commit suas mudanças (`git commit -am 'Adiciona nova feature'`).
4. Push para a branch (`git push origin feature/nova-feature`).
5. Abra um Pull Request.

## 📄 Licença

Este projeto é distribuído sob a licença MIT. Veja o arquivo `LICENSE` para mais detalhes.

## 📞 Suporte

Para dúvidas ou suporte, entre em contato através do formulário em `contato.php` ou abra uma issue no repositório.

## 🐛 Problemas Conhecidos

- Certifique-se de que o servidor suporta uploads de arquivos se adicionar funcionalidades de mídia.
- Vídeos são referenciados localmente; ajuste caminhos se hospedar em produção.

---

Desenvolvido com ❤️ para promover fitness acessível e inclusivo.