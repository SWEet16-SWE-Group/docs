DROP DATABASE IF EXISTS `easymeal`;

CREATE DATABASE `easymeal`;

USE `easymeal`;

CREATE TABLE account(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    updated_at TIMESTAMP,
    created_at TIMESTAMP
);

CREATE TABLE clienti(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    account INT NOT NULL,
    nome VARCHAR(255) NOT NULL UNIQUE,
    updated_at TIMESTAMP,
    created_at TIMESTAMP,
    FOREIGN KEY (account) REFERENCES account(id)
);

CREATE TABLE ristoratori(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    account INT NOT NULL,
    nome VARCHAR(255) NOT NULL UNIQUE,
    indirizzo VARCHAR(255) NOT NULL UNIQUE,
    telefono VARCHAR(255) NOT NULL UNIQUE,
    updated_at TIMESTAMP,
    created_at TIMESTAMP,
    FOREIGN KEY (account) REFERENCES account(id)
);

<<<<<<< HEAD
create Table orari_apertura_ristorante(
  ristorante int not null, foreign key (ristorante) references ristoratori(id),
  apertura time not null,
  chiusura time not null,
  giorno enum ('Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato','Domenica') not null,
  check( apertura < chiusura ),
  primary key (ristorante, apertura, chiusura, giorno)
);

create Table cucina_ristorante(
  ristorante int not null, foreign key (ristorante) references ristoratori(id),
  cucina enum ('pizza', 'pasta', 'pesce') not null,
  primary key (ristorante, cucina)
);
    PRIMARY KEY (ristorante, giorno, apertura, chiusura),
    FOREIGN KEY (ristorante) REFERENCES ristoratori(id),
    CHECK (apertura < chiusura)
);

CREATE TABLE cucina_ristorante(
    ristorante INT NOT NULL,
    cucina ENUM('pizza', 'pasta', 'pesce') NOT NULL,
    updated_at TIMESTAMP,
    created_at TIMESTAMP,
    PRIMARY KEY (ristorante, cucina),
    FOREIGN KEY (ristorante) REFERENCES ristoratori(id)
);

CREATE TABLE allergeni(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL UNIQUE,
    updated_at TIMESTAMP,
    created_at TIMESTAMP
);

CREATE TABLE ingredienti(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ristorante INT NOT NULL,
    nome VARCHAR(255) NOT NULL,
    updated_at TIMESTAMP,
    created_at TIMESTAMP,
    UNIQUE (ristorante, nome),
    FOREIGN KEY (ristorante) REFERENCES ristoratori(id)
>>>>>>> mvp-main
);

CREATE TABLE reagenti(
    ingrediente INT NOT NULL,
    allergene INT NOT NULL,
    updated_at TIMESTAMP,
    created_at TIMESTAMP,
    PRIMARY KEY (ingrediente, allergene),
    FOREIGN KEY (ingrediente) REFERENCES ingredienti(id),
    FOREIGN KEY (allergene) REFERENCES allergeni(id)
);

CREATE TABLE allergie(
    cliente INT NOT NULL,
    allergene INT NOT NULL,
    updated_at TIMESTAMP,
    created_at TIMESTAMP,
    PRIMARY KEY (cliente, allergene),
    FOREIGN KEY (cliente) REFERENCES clienti(id),
    FOREIGN KEY (allergene) REFERENCES allergeni(id)
);

CREATE TABLE pietanze(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ristorante INT NOT NULL,
    nome VARCHAR(255) NOT NULL,
    updated_at TIMESTAMP,
    created_at TIMESTAMP,
    UNIQUE (ristorante, nome),
    FOREIGN KEY (ristorante) REFERENCES ristoratori(id)
);

CREATE TABLE ricette(
    pietanza INT NOT NULL,
    ingrediente INT NOT NULL,
    updated_at TIMESTAMP,
    created_at TIMESTAMP,
    PRIMARY KEY (pietanza, ingrediente),
    FOREIGN KEY (pietanza) REFERENCES pietanze(id),
    FOREIGN KEY (ingrediente) REFERENCES ingredienti(id)
);

CREATE TABLE prenotazioni(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ristorante INT NOT NULL,
    timestamp DATETIME NOT NULL,
    n_inviti INT NOT NULL,
    divisione_conto ENUM('equa', 'proporzionale') NOT NULL,
    updated_at TIMESTAMP,
    created_at TIMESTAMP,
    FOREIGN KEY (ristorante) REFERENCES ristoratori(id)
);

CREATE TABLE inviti(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    prenotazione INT NOT NULL,
    cliente INT NOT NULL,
    pagamento ENUM('non_pagato', 'pagato') NOT NULL DEFAULT 'non_pagato',
    updated_at TIMESTAMP,
    created_at TIMESTAMP,
    FOREIGN KEY (prenotazione) REFERENCES prenotazioni(id),
    FOREIGN KEY (cliente) REFERENCES clienti(id)
);

CREATE TABLE ordinazioni(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    invito INT NOT NULL,
    pietanza INT NOT NULL,
    pagamento ENUM('non_pagato', 'pagato') NOT NULL DEFAULT 'non_pagato',
    updated_at TIMESTAMP,
    created_at TIMESTAMP,
    FOREIGN KEY (invito) REFERENCES inviti(id),
    FOREIGN KEY (pietanza) REFERENCES pietanze(id)
);

CREATE TABLE dettagli_ordinazione(
    ingrediente INT NOT NULL,
    ordinazione INT NOT NULL,
    dettaglio ENUM('-', '+') NOT NULL,
    updated_at TIMESTAMP,
    created_at TIMESTAMP,
    PRIMARY KEY (ingrediente, ordinazione),
    FOREIGN KEY (ingrediente) REFERENCES ingredienti(id),
    FOREIGN KEY (ordinazione) REFERENCES ordinazioni(id)
);

CREATE TABLE personal_access_tokens(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) NOT NULL,
    abilities TEXT DEFAULT NULL,
    last_used_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);