-- excuta primeiro linha 3 no php My ADMIn depôs da linha 5 ate a 16.

CREATE TABLE `idosos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `idade` int(11) NOT NULL,
  `cidade_de_origem` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `fotos_diarias` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`fotos_diarias`)),
  `videos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`videos`)),
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `likes` int(11) DEFAULT 0,
  `status` varchar(20) DEFAULT 'ativo'
);

-- //caso não funcione é so ir por partes. primeiro cria o banco

CREATE DATABASE abrigo_sao_francisco_de_assis;

-- //depôs a seguintes tabelas 

CREATE TABLE idosos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    idade INT NOT NULL,
    cidade_de_origem VARCHAR(255),
    bio TEXT,
    foto_perfil VARCHAR(255),
    fotos_diarias JSON,
    videos JSON,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- // e logo apôs de ter execultado é so fazer

ALTER TABLE idosos ADD COLUMN likes INT DEFAULT 0;