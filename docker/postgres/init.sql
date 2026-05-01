CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

DO $$
BEGIN
  IF NOT EXISTS (SELECT FROM pg_roles WHERE rolname = 'Senac') THEN
    CREATE ROLE senac LOGIN PASSWORD 'Senac';
  END IF;
END
$$;

CREATE DATABASE development_db
  OWNER senac;

CREATE DATABASE testing_db
  OWNER senac;

CREATE DATABASE production_db
  OWNER senac;

-- Conectar ao banco de desenvolvimento
\c development_db senac

CREATE TABLE IF NOT EXISTS customer (
  id SERIAL PRIMARY KEY,
  cpf_cnpj VARCHAR(18) NOT NULL UNIQUE,
  nome_fantasia VARCHAR(150) NOT NULL,
  sobrenome_razao VARCHAR(150) NOT NULL,
  inscricao_estadual VARCHAR(20),
  nascimento_fundacao DATE,
  ativo BOOLEAN DEFAULT true,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Tabela de Clientes para banco de testes
\c testing_db senac

CREATE TABLE IF NOT EXISTS customer (
  id SERIAL PRIMARY KEY,
  cpf_cnpj VARCHAR(18) NOT NULL UNIQUE,
  nome_fantasia VARCHAR(150) NOT NULL,
  sobrenome_razao VARCHAR(150) NOT NULL,
  inscricao_estadual VARCHAR(20),
  nascimento_fundacao DATE,
  ativo BOOLEAN DEFAULT true,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Clientes para banco de produção
\c production_db senac

CREATE TABLE IF NOT EXISTS customer (
  id SERIAL PRIMARY KEY,
  cpf_cnpj VARCHAR(18) NOT NULL UNIQUE,
  nome_fantasia VARCHAR(150) NOT NULL,
  sobrenome_razao VARCHAR(150) NOT NULL,
  inscricao_estadual VARCHAR(20),
  nascimento_fundacao DATE,
  ativo BOOLEAN DEFAULT true,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);