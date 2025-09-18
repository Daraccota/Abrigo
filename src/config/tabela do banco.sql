
CREATE DATABASE abrigo_sao_francisco_de_assis;

CREATE TABLE `idosos` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `nome` varchar(255) NOT NULL,
  `idade` int(11) NOT NULL,
  `cidade_de_origem` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `fotos_diarias` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`fotos_diarias`)),
  `videos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`videos`)),
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `likes` int(11) DEFAULT 0,
  `status` enum('ativo','inativo','revisar') DEFAULT 'ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE comunicados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mensagem TEXT NOT NULL,
    tipo ENUM('publicado','agendado') DEFAULT 'publicado',
    data_publicacao DATETIME NOT NULL
);

CREATE TABLE eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    data DATE NOT NULL,
    hora TIME NOT NULL,
    tipo ENUM('Missas','Festividades','Formações','Outros') NOT NULL
);
