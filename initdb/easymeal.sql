SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

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
  account int not null references account(id),
  nome varchar(255) not null unique
);

create table ristoratori(
  id int not null auto_increment primary key,
  account int not null references account(id),
  nome varchar(255) not null unique,
  indirizzo varchar(255) not null unique,
  telefono varchar(255) not null unique
);

create table allergeni(
  id int not null auto_increment primary key,
  nome varchar(255) not null unique
);

create table ingredienti(
  id int not null auto_increment primary key,
  ristorante int not null references ristoratori(id),
  nome varchar(255) not null
);

create table reagenti(
  ingrediente int not null references ingredienti(id),
  allergene   int not null references allergeni(id)  ,
  primary key (ingrediente, allergene)
);

create table allergie(
  cliente   int not null references clienti(id)  ,
  allergene int not null references allergeni(id),
  primary key (cliente, allergene)
);
