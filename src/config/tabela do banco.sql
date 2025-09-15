-- excuta primeiro linha 3 no php My ADMIn depôs da linha 5 ate a 16.

CREATE DATABASE abrigo_sao_francisco_de_assis;

CREATE TABLE idosos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    idade INT NOT NULL,
    cidade_de_origem VARCHAR(255),
    bio TEXT,
    foto_perfil VARCHAR(255),
    fotos_diarias JSON,
    videos JSON,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    likes INT DEFAULT 0
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