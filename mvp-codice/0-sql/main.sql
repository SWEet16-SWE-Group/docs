
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


delimiter $$

create function assert(errcode int) returns varchar(255) deterministic
begin
  return if(errcode = 1, 'OKK', 'ERR') ;
end $$

create function insert_cliente(profilo int) returns int deterministic
begin
  declare ris int;
  insert into clienti(id) select p.id from profili as p left join ristoratori as r on p.id = r.id left join clienti as c on p.id = c.id where r.id is null and c.id is null and p.id = profilo;
  select count(*) into ris from clienti where id = profilo;
  return ris;
end $$

delimiter ;
