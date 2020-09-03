CREATE TABLE administracao.cidade (
  idcidade SERIAL,
  descricao VARCHAR(150) NULL,
  PRIMARY KEY(idcidade)
);

CREATE TABLE administracao.pessoa (
  idpessoa SERIAL,
  naturalidade INTEGER  NOT NULL,
  nome VARCHAR(150) NULL,
  datanascimento DATE NULL,
  sexo CHAR(1) NULL,
  cpf VARCHAR(11) NULL,
  nomemae VARCHAR(150) NULL,
  email VARCHAR(80) NULL,
  telefone1 VARCHAR(20) NULL,
  telefone2 VARCHAR(20) NULL,
  PRIMARY KEY(idpessoa),
  FOREIGN KEY(naturalidade)
    REFERENCES cidade(idcidade)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  CONSTRAINT U_CPF UNIQUE (cpf)
);

CREATE TABLE administracao.usuario (
  idusuario SERIAL,
  idpessoa INTEGER  NOT NULL,
  login VARCHAR(35) NULL,
  senha VARCHAR(40) NULL,
  ativo CHAR(1) NULL,
  PRIMARY KEY(idusuario),
  FOREIGN KEY(idpessoa)
    REFERENCES pessoa(idpessoa)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE administracao.historico_senha (
  idhistorico_senha SERIAL,
  idusuario INTEGER  NOT NULL,
  senha VARCHAR(40) NULL,
  datacadastro DATE NULL,
  dataalteracao DATE NULL,
  PRIMARY KEY(idhistorico_senha),
  FOREIGN KEY(idusuario)
    REFERENCES usuario(idusuario)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE administracao.token (
  idtoken SERIAL,
  idusuario INTEGER  NOT NULL,
  token VARCHAR(1000) NULL,
  refreshtoken VARCHAR(1000) NULL,
  dataexpira TIMESTAMP NOT NULL,
  PRIMARY KEY(idtoken),
  FOREIGN KEY(idusuario)
    REFERENCES usuario(idusuario)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);


