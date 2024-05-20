
DROP DATABASE IF EXISTS `easymeal`;
CREATE DATABASE `easymeal`;
USE `easymeal`;


create table account(
  id int not null auto_increment primary key ,
  mail varchar(255) not null unique,
  password varchar(255) not null
);

create table clienti(
  id int not null auto_increment primary key,
  account int not null, foreign key (account) references account(id),
  nome varchar(255) not null unique
  -- decidere se nome globale tra tutti i clienti o solo nel contesto di un account
);

create table ristoratori(
  id int not null auto_increment primary key,
  account int not null, foreign key (account) references account(id),
  nome varchar(255) not null unique,
  indirizzo varchar(255) not null unique,
  telefono varchar(255) not null unique
);

create table orari_apertura_ristorante(
  ristorante int not null, foreign key (ristorante) references ristoratori(id),
  apertura time not null,
  chiusura time not null,
  giorno enum ('月','火','水','木','金','土','日') not null,
  check( apertura < chiusura ),
  primary key (ristorante, apertura, chiusura, giorno)
);

create table cucina_ristorante(
  ristorante int not null, foreign key (ristorante) references ristoratori(id),
  cucina enum ('pizza', 'pasta', 'pesce') not null,
  primary key (ristorante, cucina)
);

create table allergeni(
  id int not null auto_increment primary key,
  nome varchar(255) not null unique
);

create table ingredienti(
  id int not null auto_increment primary key,
  ristorante int not null, foreign key (ristorante) references ristoratori(id),
  nome varchar(255) not null,
  unique (ristorante, nome)
);

create table reagenti(
  ingrediente int not null, foreign key (ingrediente) references ingredienti(id),
  allergene   int not null, foreign key (allergene) references allergeni(id),
  primary key (ingrediente, allergene)
);

create table allergie(
  cliente   int not null, foreign key (cliente) references clienti(id),
  allergene int not null, foreign key (allergene) references allergeni(id),
  primary key (cliente, allergene)
);

create table pietanze(
  id int not null auto_increment primary key,
  ristorante int not null, foreign key (ristorante) references ristoratori(id),
  nome varchar(255) not null,
  unique (ristorante, nome)
);

create table ricette(
  pietanza    int not null, foreign key (pietanza) references pietanze(id),
  ingrediente int not null, foreign key (ingrediente) references ingredienti(id),
  primary key (pietanza, ingrediente)
);

create table prenotazioni(
  id int not null auto_increment primary key,
  ristorante int not null, foreign key (ristorante) references ristoratori(id),
  timestamp datetime not null,
  n_inviti int not null,
  divisione_conto enum ('equa', 'proporzionale') not null
);

create table inviti(
  id int not null auto_increment primary key,
  prenotazione int not null, foreign key (prenotazione) references prenotazioni(id),
  cliente   int not null, foreign key (cliente) references clienti(id),
  pagamento enum ('non_pagato', 'pagato') not null
  -- necessario se divisione equa
);

create table ordinazioni(
  id int not null auto_increment primary key,
  invito int not null, foreign key (invito) references inviti(id),
  pietanza int not null, foreign key (pietanza) references pietanze(id),
  pagamento enum ('non_pagato', 'pagato') not null
  -- necessario se divisione proporzionale
);

create table dettagli_ordinazione(
  ingrediente int not null, foreign key (ingrediente) references ingredienti(id),
  ordinazione int not null, foreign key (ordinazione) references ordinazioni(id),
  dettaglio enum ('-', '+') not null,
  primary key (ingrediente, ordinazione)
);
