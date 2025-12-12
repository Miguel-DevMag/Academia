<?php
/**
 * setup.php - Executa o database.sql para criar o banco de dados e tabelas
 * Acesse http://localhost/Academia/setup.php em seu navegador
 */

$servidor = "localhost";
$usuario = "root";
$senha = "";

// Conecta ao MySQL SEM selecionar DB
$conn = new mysqli($servidor, $usuario, $senha);

if ($conn->connect_error) {
    die("❌ Erro ao conectar no servidor MySQL: " . $conn->connect_error);
}

// SQL do database
$sql = "
CREATE DATABASE IF NOT EXISTS `academia` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `academia`;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(191) NOT NULL,
  email VARCHAR(191) NOT NULL UNIQUE,
  usuario VARCHAR(100) NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS depoimentos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(191) DEFAULT NULL,
  texto TEXT NOT NULL,
  video_src VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS videos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  descricao TEXT DEFAULT NULL,
  src VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS suplementos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(191) NOT NULL,
  descricao TEXT DEFAULT NULL,
  preco DECIMAL(10,2) DEFAULT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS treinos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  grupo VARCHAR(100) NOT NULL,
  titulo VARCHAR(255) NOT NULL,
  exercicios JSON DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS anabolizantes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  codigo VARCHAR(50) NOT NULL UNIQUE,
  nome VARCHAR(191) NOT NULL,
  risco TEXT DEFAULT NULL,
  descricao TEXT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS contatos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(191) NOT NULL,
  email VARCHAR(191) NOT NULL,
  mensagem TEXT NOT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO videos (titulo, descricao, src) VALUES
('Treino Adaptado de Musculação','Vídeo mostrando como um treino de musculação pode ser adaptado para diferentes necessidades.','videos/video1.mp4'),
('Aula de Dança Inclusiva','Vídeo de uma aula de dança inclusiva, mostrando movimentos adaptados e ritmo.','videos/video2.mp4'),
('Artes Marciais Adaptadas','Vídeo de artes marciais adaptadas, explicando técnicas seguras e defesa pessoal.','videos/video3.mp4');
";

// Executa múltiplas queries
if ($conn->multi_query($sql) === TRUE) {
    // Consome todos os resultados
    while ($conn->more_results() && $conn->next_result()) {
        if (is_object($conn->use_result())) {
            $conn->use_result()->free();
        }
    }
    echo "✅ Banco de dados 'academia' criado e populado com sucesso!<br>";
    echo "Tabelas criadas: users, depoimentos, videos, suplementos, treinos, anabolizantes, contatos<br>";
    echo "<a href='index.html'>← Voltar para a página inicial</a>";
} else {
    echo "❌ Erro ao executar queries: " . $conn->error;
}

$conn->close();
?>
