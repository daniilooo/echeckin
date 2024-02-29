-- Criação da Tabela 'ilhas'
CREATE TABLE ilhas (
    id_ilha INT PRIMARY KEY AUTO_INCREMENT,
    nome_ilha VARCHAR(255) NOT NULL,
    -- Adicione outros campos relevantes para as ilhas
);

-- Criação da Tabela 'operadores'
CREATE TABLE operadores (
    id_operador INT PRIMARY KEY AUTO_INCREMENT,
    nome_operador VARCHAR(255) NOT NULL,
    -- Adicione outros campos relacionados aos operadores
);

-- Criação da Tabela 'checkins_ilhas'
CREATE TABLE checkins_ilhas (
    id_checkin INT PRIMARY KEY AUTO_INCREMENT,
    id_ilha INT,
    id_operador INT,
    horario_checkin TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_ilha) REFERENCES ilhas(id_ilha),
    FOREIGN KEY (id_operador) REFERENCES operadores(id_operador)
);

-- Criação da Tabela 'pontos_ronda'
CREATE TABLE pontos_ronda (
    id_ponto INT PRIMARY KEY AUTO_INCREMENT,
    nome_ponto VARCHAR(255) NOT NULL,
    -- Adicione outros campos relevantes para os pontos de ronda
);

-- Criação da Tabela 'guardas'
CREATE TABLE guardas (
    id_guarda INT PRIMARY KEY AUTO_INCREMENT,
    nome_guarda VARCHAR(255) NOT NULL,
    -- Adicione outros campos relacionados aos guardas
);

-- Criação da Tabela 'checkins_rondas'
CREATE TABLE checkins_rondas (
    id_checkin INT PRIMARY KEY AUTO_INCREMENT,
    id_ponto INT,
    id_guarda INT,
    horario_checkin TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_ponto) REFERENCES pontos_ronda(id_ponto),
    FOREIGN KEY (id_guarda) REFERENCES guardas(id_guarda)
);
