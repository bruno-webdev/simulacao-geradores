CREATE TABLE IF NOT EXISTS ufs (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(20) NOT NULL,
    abbreviation CHAR(2) NOT NULL,
    kwh FLOAT(10, 2)
);

INSERT INTO ufs (name, abbreviation, kwh)
VALUES
    ('Rondônia', 'RO', 0.75),
    ('Acre', 'AC', 0.75),
    ('Amazonas', 'AM', 0.75),
    ('Roraima', 'RR', 0.75),
    ('Pará', 'PA', 0.75),
    ('Amapá', 'AP', 0.75),
    ('Tocantins', 'TO', 0.75),
    ('Maranhão', 'MA', 0.75),
    ('Piauí', 'PI', 0.75),
    ('Ceará', 'CE', 0.75),
    ('Rio Grande do Norte', 'RN', 0.75),
    ('Paraíba', 'PB', 0.75),
    ('Pernambuco', 'PE', 0.75),
    ('Alagoas', 'AL', 0.75),
    ('Sergipe', 'SE', 0.75),
    ('Bahia', 'BA', 0.75),
    ('Minas Gerais', 'MG', 0.75),
    ('Espírito Santo', 'ES', 0.75),
    ('Rio de Janeiro', 'RJ', 0.75),
    ('São Paulo', 'SP', 0.75),
    ('Paraná', 'PR', 0.75),
    ('Santa Catarina', 'SC', 0.75),
    ('Rio Grande do Sul', 'RS', 0.75),
    ('Mato Grosso do Sul', 'MS', 0.75),
    ('Mato Grosso', 'MT', 0.75),
    ('Goiás', 'GO', 0.75),
    ('Distrito Federal', 'DF', 0.75);

CREATE TABLE IF NOT EXISTS parameters (
   id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
   name VARCHAR(255) NOT NULL,
   value VARCHAR(255) NOT NULL,
   notes LONGTEXT
);

INSERT INTO parameters (name, value) VALUES ('custo_gerador', 999), ('preco_instalacao', 1000);

CREATE TABLE IF NOT EXISTS logs (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    phone CHAR(11),
    price FLOAT (10, 2),
    address VARCHAR(255),
    city VARCHAR(255),
    uf CHAR(2),
    energy_generator_price FLOAT(10, 2),
    install_price FLOAT(10, 2),
    kwh_month FLOAT(10, 2),
    approximate_cost FLOAT(10, 2),
    months_profit FLOAT(10, 2),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP
);