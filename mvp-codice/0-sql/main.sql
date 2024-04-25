
drop database if exists easymeal;
create database easymeal;
use easymeal;


create table accounts     (id int not null auto_increment primary key);
create table profili      (id int not null auto_increment primary key, account int not null, foreign key (account) references accounts(id));
create table clienti      (id int not null primary key, foreign key (id) references profili(id));
create table ristoratori  (id int not null primary key, foreign key (id) references profili(id));
-- create table messaggi     ();
-- create table recensioni   ();
-- create table prenotazioni ();
-- create table allrgeni     ();
-- create table allergie     ();
-- create table ingredienti  ();
-- create table ricette      ();
-- create table pietanze     ();
-- create table ordinazioni  ();
-- create table aggiunti     ();
-- create table rimossi      ();
