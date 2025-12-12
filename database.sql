-- Database schema for Academia project
CREATE DATABASE IF NOT EXISTS `academia` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `academia`;

-- Users table (login & account creation)
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(191) NOT NULL,
  email VARCHAR(191) NOT NULL UNIQUE,
  usuario VARCHAR(100) NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Testimonials / depoimentos
CREATE TABLE IF NOT EXISTS depoimentos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(191) DEFAULT NULL,
  texto TEXT NOT NULL,
  video_src VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Videos metadata
CREATE TABLE IF NOT EXISTS videos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  descricao TEXT DEFAULT NULL,
  src VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Suplementos (basic)
CREATE TABLE IF NOT EXISTS suplementos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(191) NOT NULL,
  descricao TEXT DEFAULT NULL,
  preco DECIMAL(10,2) DEFAULT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Treinos and exercises (exercises stored as JSON)
CREATE TABLE IF NOT EXISTS treinos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  grupo VARCHAR(100) NOT NULL,
  titulo VARCHAR(255) NOT NULL,
  exercicios JSON DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Anabolizantes info
CREATE TABLE IF NOT EXISTS anabolizantes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  codigo VARCHAR(50) NOT NULL UNIQUE,
  nome VARCHAR(191) NOT NULL,
  risco TEXT DEFAULT NULL,
  descricao TEXT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contato messages
CREATE TABLE IF NOT EXISTS contatos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(191) NOT NULL,
  email VARCHAR(191) NOT NULL,
  mensagem TEXT NOT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Optional: populate videos from barra_acesessibilidade.php dataset
INSERT IGNORE INTO videos (titulo, descricao, src) VALUES
('Treino Adaptado de Musculação','Vídeo mostrando como um treino de musculação pode ser adaptado para diferentes necessidades.','videos/video1.mp4'),
('Aula de Dança Inclusiva','Vídeo de uma aula de dança inclusiva, mostrando movimentos adaptados e ritmo.','videos/video2.mp4'),
('Artes Marciais Adaptadas','Vídeo de artes marciais adaptadas, explicando técnicas seguras e defesa pessoal.','videos/video3.mp4');
