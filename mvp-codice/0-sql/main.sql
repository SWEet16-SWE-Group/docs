
drop database if exists easymeal;
create database easymeal;
use easymeal;


create table accounts     (id int not null auto_increment primary key);
create table profili      (id int not null auto_increment primary key, account int not null, foreign key (account) references accounts(id));
create table clienti      (id int not null primary key, foreign key (id) references profili(id));
create table ristoratori  (id int not null primary key, foreign key (id) references profili(id));
create table messaggi     (time datetime not null default CURRENT_TIMESTAMP, mittente int not null, destinatario int not null, primary key (time,mittente,destinatario), foreign key (mittente) references profili(id), foreign key (destinatario) references profili(id));
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


delimiter $$

create function assert(errcode int, name varchar(255)) returns varchar(255) deterministic
begin
  return concat('[[',if(errcode = 1, 'OKK', 'ERR'),']] ',name) ;
end $$

create view profili_staminali as
  select p.id as id
    from profili as p
    left join ristoratori as r on p.id = r.id
    left join clienti as c on p.id = c.id
    where r.id is null and c.id is null
$$

create function insert_cliente(profilo int) returns int deterministic
begin
  declare ris int;
  select count(*) into ris from clienti where id = profilo;
  if ris > 0 then return 0; end if;
  insert into clienti(id) select id from profili_staminali where id = profilo;
  select count(*) into ris from clienti where id = profilo;
  return ris;
end $$

create function insert_ristoratori(profilo int) returns int deterministic
begin
  declare ris int;
  select count(*) into ris from ristoratori where id = profilo;
  if ris > 0 then return 0; end if;
  insert into ristoratori(id) select id from profili_staminali where id = profilo;
  select count(*) into ris from ristoratori where id = profilo;
  return ris;
end $$

create function insert_messaggio(mittente int, destinatario int) returns int deterministic
begin
  return -1;
end $$

create function registrazione() returns int deterministic begin return -1; end $$
create function accesso() returns int deterministic begin return -1; end $$
create function insert_profilo() returns int deterministic begin return -1; end $$

create function insert_allergia() returns int deterministic begin return -1; end $$
create function insert_recensione() returns int deterministic begin return -1; end $$

create function insert_prenotazione() returns int deterministic begin return -1; end $$
create function insert_invitato() returns int deterministic begin return -1; end $$
create function insert_ordinazione() returns int deterministic begin return -1; end $$
create function add_ingrediente_ordinazione() returns int deterministic begin return -1; end $$
create function del_ingrediente_ordinazione() returns int deterministic begin return -1; end $$

create function insert_ingrediente() returns int deterministic begin return -1; end $$
create function insert_ingrediente_allergico() returns int deterministic begin return -1; end $$
create function insert_pietanza() returns int deterministic begin return -1; end $$
create function insert_ricetta() returns int deterministic begin return -1; end $$

delimiter ;
