CREATE DATABASE ECHECKIN;

USE ECHECKIN;

CREATE TABLE TBL_USUARIO(
	ID_USUARIO INT NOT NULL AUTO_INCREMENT,
	NOME VARCHAR(30),
	MATRICULA VARCHAR(30),
	EMPRESA INT,
	CARGO INT,
	LOGIN VARCHAR (20),
	SENHA VARCHAR (255),
	STATUS_USUARIO INT,
	PRIMARY KEY (ID_USUARIO),
	FOREIGN KEY (EMPRESA) REFERENCES TBL_EMPRESA(ID_EMPRESA),
	FOREIGN KEY (CARGO) REFERENCES TBL_CARGOS(ID_CARGO)
);

CREATE TABLE TBL_EMPRESA(
	ID_EMPRESA INT NOT NULL AUTO_INCREMENT,
	RAZAO_SOCIAL VARCHAR (30),
	CNPJ VARCHAR (18),
	STATUS_EMPRESA INT,
	PRIMARY KEY (ID_EMPRESA)
);

CREATE TABLE TBL_LOCAIS(
	ID_LOCAL INT NOT NULL AUTO_INCREMENT,
	ID_EMPRESA INT NOT NULL,
	TIPO_LOCAL INT NOT NULL,
	DESC_LOCAL VARCHAR(30),
	STATUS_LOCAL INT,
	PRIMARY KEY (ID_LOCAL)
);

CREATE TABLE TBL_CARGOS(
	ID_CARGO INT NOT NULL AUTO_INCREMENT,
	DESCRICAO_CARGO VARCHAR(30),
	STATUS_CARGO INT,
	PRIMARY KEY (ID_CARGO)
);

CREATE TABLE TBL_TIPOS_LOCAIS(
	ID_TIPOCARGO INT NOT NULL AUTO_INCREMENT,
	DESCRICAO_TIPOLOCAL VARCHAR(20),
	STATUS_TIPOLOCAL INT,
	PRIMARY KEY (ID_TIPOCARGO)
);

CREATE TABLE TBL_LOG(
	ID_LOG INT NOT NULL AUTO_INCREMENT,
	REGLOG TEXT,
	DATAHORA DATETIME,
	ID_USUARIO INT,
	PRIMARY KEY (ID_LOG),
	FOREIGN KEY (ID_USUARIO) REFERENCES TBL_USUARIO(ID_USUARIO)
);

INSERT INTO TBL_CARGOS (DESCRICAO_CARGO, STATUS_CARGO) VALUES ('CONTROLADOR DE ACESSO', '1');
INSERT INTO TBL_CARGOS (DESCRICAO_CARGO, STATUS_CARGO) VALUES ('OPERADOR DE ILHA', '1');
INSERT INTO TBL_CARGOS (DESCRICAO_CARGO, STATUS_CARGO) VALUES ('DESENVOLVEDOR', '1');
INSERT INTO TBL_CARGOS (DESCRICAO_CARGO, STATUS_CARGO) VALUES ('ADMINISTRADOR', '1');

INSERT INTO TBL_TIPOS_LOCAIS (DESCRICAO_TIPOLOCAL, STATUS_TIPOLOCAL) VALUES ('PONTO DE RONDA', '1');
INSERT INTO TBL_TIPOS_LOCAIS (DESCRICAO_TIPOLOCAL, STATUS_TIPOLOCAL) VALUES ('ILHA DE CARREGAMENTO / DESCARREGAMENTO', '1');

INSERT INTO TBL_EMPRESA(RAZAO_SOCIAL, CNPJ, STATUS_EMPRESA) VALUES ('PRODEV DESENVOLVIMENTO DE SISTEMAS', '39.345.960/0001-29', '1');
UPDATE TBL_USUARIO SET EMPRESA = 1 AND CARGO = 3 WHERE ID_USUARIO = 1
UPDATE TBL_USUARIO SET NOME= "Danilo Franco" WHERE ID_USUARIO = 1

INSERT INTO TBL_LOCAIS (FK_EMPRESA, FK_TIPO_LOCAL, DESC_LOCAL, STATUS_LOCAL) VALUES (1,1, 'LOCAL FICTICIO PARA TESTE', 1);
INSERT INTO TBL_LOCAIS (FK_EMPRESA, FK_TIPO_LOCAL, DESC_LOCAL, STATUS_LOCAL) VALUES (1,2, 'TESTE DE TRIGGER', 1);

/*
ALTER TABLE TBL_LOCAIS
ADD CONSTRAINT FK_EMPRESA FOREIGN KEY (FK_EMPRESA) REFERENCES TBL_EMPRESA(ID_EMPRESA),
ADD CONSTRAINT FK_TIPO_LOCAL FOREIGN KEY (FK_TIPO_LOCAL) REFERENCES TBL_LOCAIS(ID_TIPO_LOCAL);
*/

/*
ALTER TABLE TBL_TIPOS_LOCAIS
CHANGE COLUMN ID_TIPOCARGO ID_TIPO_LOCAL INT;
*/

ALTER TABLE TBL_CARGOS
CHANGE COLUMN NIVEL_ACESSO FK_NIVEL_ACESSO INT;

ALTER TABLE TBL_CARGOS
ADD CONSTRAINT FK_NIVEIS_ACESSO FOREIGN KEY (FK_NIVEL_ACESSO) REFERENCES TBL_NIVEIS_ACESSO(ID_NIVEL_ACESSO);

CREATE TABLE TBL_CHECKIN(
	ID_CHECKIN INT NOT NULL AUTO_INCREMENT,
	FK_LOCAL INT NOT NULL,
	FK_USUARIO INT NOT NULL,
	DATAHORA_CHECKIN DATETIME NOT NULL,
	PRIMARY KEY(ID_CHECKIN),
	FOREIGN KEY (FK_LOCAL) REFERENCES TBL_LOCAIS(ID_LOCAL),
	FOREIGN KEY (FK_USUARIO) REFERENCES TBL_USUARIO(ID_USUARIO)
);

CREATE TABLE TBL_JUSTIFICATIVA(
	ID_JUSTIFICATIVA INT NOT NULL AUTO_INCREMENT,
	FK_USUARIO INT NOT NULL,
	FK_LOCAL INT NOT NULL,
	JUSTIFICATIVA TEXT NOT NULL,
	DATE_HORA DATETIME NOT NULL,
	PRIMARY KEY(ID_JUSTIFICATIVA),
	FOREIGN KEY (FK_USUARIO) REFERENCES TBL_USUARIO(ID_USUARIO),
	FOREIGN KEY (FK_LOCAL) REFERENCES TBL_LOCAIS(ID_LOCAL)
);

INSERT INTO TBL_JUSTIFICATIVA VALUES(NULL, 1, 1, "TESTE DE INSERÇÃO DE JUSTIFICATIVA", NOW());

CREATE TABLE TBL_ERRO(
	ID_ERRO INT NOT NULL AUTO_INCREMENT,
	DESC_ERRO TEXT NOT NULL,
	LOCAL TEXT NOT NULL,
	DATA DATETIME NOT NULL,
	FK_USUARIO INT NOT NULL,
	PRIMARY KEY (ID_ERRO),
	FOREIGN KEY (FK_USUARIO) REFERENCES TBL_USUARIO(ID_USUARIO)
);

ALTER TABLE TBL_EMPRESA 
ADD COLUMN QTD_LOCAIS INT;

SELECT 
    TBL_LOCAIS.ID_LOCAL,
    TBL_TIPOS_LOCAIS.DESCRICAO_TIPOLOCAL,
    TBL_LOCAIS.FK_EMPRESA,
    TBL_LOCAIS.DESC_LOCAL,
    TBL_LOCAIS.STATUS_LOCAL    
FROM 
    TBL_LOCAIS
JOIN 
    TBL_TIPOS_LOCAIS ON TBL_LOCAIS.FK_TIPO_LOCAL = TBL_TIPOS_LOCAIS.ID_TIPO_LOCAL;

ALTER TABLE TBL_CARGOS
ADD COLUMN NIVEL_ACESSO INT;

CREATE TABLE TBL_NIVEIS_ACESSO(
	ID_NIVEL_ACESSO INT NOT NULL AUTO_INCREMENT,
	DESC_NIVEL_ACESSO VARCHAR(20),
	PRIMARY KEY (ID_NIVEL_ACESSO)
);

INSERT INTO TBL_NIVEIS_ACESSO VALUES (NULL, 'ADMINISTRADOR');
INSERT INTO TBL_NIVEIS_ACESSO VALUES (NULL, 'DESENVOLVEDOR');
INSERT INTO TBL_NIVEIS_ACESSO VALUES (NULL, 'OPERADOR DE ILHA');
INSERT INTO TBL_NIVEIS_ACESSO VALUES (NULL, 'RONDANTE');

ALTER TABLE TBL_NIVEIS_ACESSO
ADD COLUMN STATUS_NIVELACESSO INT NOT NULL;

SELECT C.ID_CARGO, COUNT(U.ID_USUARIO) AS QUANTIDADE
FROM TBL_CARGOS C
INNER JOIN TBL_USUARIO U ON C.ID_CARGO = U.CARGO
GROUP BY C.ID_CARGO;

CREATE VIEW USUARIO_CARGO_ACESSO AS
SELECT USUARIO.ID_USUARIO AS USUARIO, CARGO.ID_CARGO AS CARGO, ACESSO.ID_NIVEL_ACESSO AS NIVEL_ACESSO
FROM TBL_USUARIO USUARIO
INNER JOIN TBL_CARGOS CARGO ON USUARIO.CARGO = CARGO.ID_CARGO
INNER JOIN TBL_NIVEIS_ACESSO ACESSO ON CARGO.FK_NIVEL_ACESSO = ACESSO.ID_NIVEL_ACESSO

SELECT DESCRICAO_CARGO, COUNT(USUARIO) AS QUANTIDADE_USUARIOS 
FROM USUARIO_CARGO_ACESSO
INNER JOIN TBL_CARGOS ON CARGO = ID_CARGO
GROUP BY CARGO 

SELECT USUARIO.NOME, CARGO.DESCRICAO_CARGO, ACESSO.DESC_NIVEL_ACESSO
FROM USUARIO_CARGO_ACESSO VISTA
INNER JOIN TBL_USUARIO USUARIO ON VISTA.USUARIO = USUARIO.ID_USUARIO
INNER JOIN TBL_CARGOS CARGO ON VISTA.CARGO = CARGO.ID_CARGO
INNER JOIN TBL_NIVEIS_ACESSO ACESSO ON VISTA.NIVEL_ACESSO = ACESSO.ID_NIVEL_ACESSO

ALTER TABLE TBL_JUSTIFICATIVA
CHANGE DATE_HORA DATA_HORA DATETIME;

SELECT EMPRESA.RAZAO_SOCIAL, LOCAL.DESC_LOCAL
FROM TBL_EMPRESA EMPRESA
INNER JOIN TBL_LOCAIS LOCAL ON EMPRESA.ID_EMPRESA = LOCAL.FK_EMPRESA;


CREATE VIEW EMPRESA_LOCAL_JUSTIFICATIVA AS
SELECT JUST.ID_JUSTIFICATIVA, EMPRESA.ID_EMPRESA AS FK_EMPRESA, JUST.FK_USUARIO, JUST.FK_LOCAL, JUST.JUSTIFICATIVA, JUST.DATA_HORA
FROM TBL_EMPRESA EMPRESA
INNER JOIN TBL_LOCAIS LOCAL ON EMPRESA.ID_EMPRESA = LOCAL.ID_LOCAL
INNER JOIN TBL_JUSTIFICATIVA JUST ON JUST.FK_LOCAL = LOCAL.ID_LOCAL;


SELECT ID_USUARIO, NOME FROM TBL_USUARIO WHERE EMPRESA = 1;

/*CONTAGEM DE COLABORADORES POR CARGO*/

SELECT USUARIO.CARGO AS ID_CARGO, CARGO.DESCRICAO_CARGO AS CARGO, COUNT(USUARIO.ID_USUARIO) AS QUANTIDADE_USUARIOS
FROM TBL_USUARIO USUARIO
INNER JOIN TBL_CARGOS CARGO ON USUARIO.CARGO = CARGO.ID_CARGO
GROUP BY USUARIO.CARGO;

/*VERIFICAÇÃO DO CARGO POR COLABORADOR*/

SELECT USUARIO.ID_USUARIO, USUARIO.NOME, USUARIO.MATRICULA, USUARIO.EMPRESA, CARGO.DESCRICAO_CARGO, USUARIO.LOGIN, USUARIO.STATUS_USUARIO 
FROM TBL_USUARIO USUARIO
INNER JOIN TBL_CARGOS CARGO ON USUARIO.CARGO = CARGO.ID_CARGO
ORDER BY CARGO.DESCRICAO_CARGO ASC;


/*CONTAGEM DE COLABORADORES POR CARGO*/
SELECT CARGO AS ID_CARGO, COUNT(CARGO)
FROM TBL_USUARIO
GROUP BY CARGO;

/*CONTAGEM DE COLABORADORES PUXANDO A DESCRIÇÃO DO CARGO*/
SELECT USUARIO.CARGO AS ID_CARGO, CARGO.DESCRICAO_CARGO , COUNT(USUARIO.CARGO) AS QUANTIDADE_USUARIOS_CARGO
FROM TBL_USUARIO USUARIO
INNER JOIN TBL_CARGOS CARGO ON USUARIO.CARGO = CARGO.ID_CARGO
GROUP BY USUARIO.CARGO;

/*CRIAÇÃO DA VIEW QUANT_USUARIO_CARGO*/
CREATE VIEW QUANT_USUARIO_CARGO AS
SELECT USUARIO.CARGO AS ID_CARGO, CARGO.DESCRICAO_CARGO , COUNT(USUARIO.CARGO) AS QUANTIDADE_USUARIOS_CARGO
FROM TBL_USUARIO USUARIO
INNER JOIN TBL_CARGOS CARGO ON USUARIO.CARGO = CARGO.ID_CARGO
GROUP BY USUARIO.CARGO; 

/*CONSULTA DA VIEW*/

SELECT * FROM QUANT_USUARIO_CARGO;


/*CONSULTA DE EMPRESA PELO CHECKIN GERAL*/

SELECT C.ID_CHECKIN, C.FK_LOCAL, L.FK_EMPRESA, C.FK_USUARIO, C.DATAHORA_CHECKIN AS OCORRENCIA
FROM TBL_CHECKIN C
INNER JOIN TBL_LOCAIS L ON C.FK_LOCAL = L.ID_LOCAL
ORDER BY C.ID_CHECKIN;

/*CONSULTA DE EMPRESA PELO CHECKIN FILTRANDO PELO FK DA EMPRESA*/

SELECT C.ID_CHECKIN, C.FK_LOCAL, L.FK_EMPRESA, C.FK_USUARIO, C.DATAHORA_CHECKIN AS OCORRENCIA
FROM TBL_CHECKIN C
INNER JOIN TBL_LOCAIS L ON C.FK_LOCAL = L.ID_LOCAL
WHERE L.FK_EMPRESA = 2
ORDER BY C.ID_CHECKIN;

/*CRIAÇÃO DA VIEW CHECKIN_LOCAL_EMPRESA_USUARIO*/

CREATE VIEW CHECKIN_LOCAL_EMPRESA_USUARIO AS
SELECT C.ID_CHECKIN, C.FK_LOCAL, L.FK_EMPRESA, C.FK_USUARIO, C.DATAHORA_CHECKIN AS OCORRENCIA
FROM TBL_CHECKIN C
INNER JOIN TBL_LOCAIS L ON C.FK_LOCAL = L.ID_LOCAL
ORDER BY C.ID_CHECKIN;

/*CONTAGEM DE CHECKINS POR EMPRESA*/

SELECT FK_EMPRESA AS EMPRESA, COUNT(ID_CHECKIN)
FROM CHECKIN_LOCAL_EMPRESA_USUARIO
GROUP BY FK_EMPRESA;

/*CONTAGEM DE CHECKINS PUXANDO RAZAO SOCIAL DA EMPRESA*/

SELECT E.RAZAO_SOCIAL, COUNT(V.ID_CHECKIN) AS QUANT_CHECKIN
FROM CHECKIN_LOCAL_EMPRESA_USUARIO V
INNER JOIN TBL_EMPRESA E ON V.FK_EMPRESA = E.ID_EMPRESA
GROUP BY E.RAZAO_SOCIAL;


/*TRIGGER PARA ATUALIZAÇÃO DA QUANTIDADE DE LOCAIS*/

BEGIN
    DECLARE num_locais INT;

    -- Conta a quantidade de locais para a FK_EMPRESA do novo local
    SELECT COUNT(*) INTO num_locais
    FROM TBL_LOCAIS
    WHERE FK_EMPRESA = NEW.FK_EMPRESA;

    -- Atualiza a quantidade de locais na TBL_EMPRESA
    UPDATE TBL_EMPRESA
    SET QTD_LOCAIS = num_locais
    WHERE ID_EMPRESA = NEW.FK_EMPRESA;
END

/*
INCLUSÃO DE EMPRESA
INCLUSÃO DE LOCAL
INCLUSÃO DE USUÁRIO
INCLUSÃO DE CARGOP

ALTERAÇÃO DE EMPRESA
ALTERAÇÃO DE LOCAL
ALTERAÇÃO DE USUÁRIO
ALTERAÇÃO DE CARGO

ALTERAÇÃO DE STATUS DE EMPRESA
ALTERAÇÃO DE STATUS DE LOCAL
ALTERAÇÃO DE STATUS DE USUÁRIO
ALTERAÇÃO DE STATUS DE CARGO

GERAÇÃO DE CHECKPOINT
*/

/*CONTAGEM DE USUARIOS POR NIVEL DE ACESSO*/

SELECT NIVEL_ACESSO, COUNT(*) 
FROM usuario_cargo_acesso
GROUP BY NIVEL_ACESSO;