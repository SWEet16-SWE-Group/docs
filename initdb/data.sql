
insert into allergeni(id,nome) values(1,'abba');
insert into allergeni(id,nome) values(2,'abbb');
insert into allergeni(id,nome) values(3,'abbc');
insert into allergeni(id,nome) values(4,'abbd');

insert into account(id,mail,password) values(1,'a','a');

insert into clienti(id,account,nome) values(1,1,'a');
insert into clienti(id,account,nome) values(2,1,'b');
insert into clienti(id,account,nome) values(3,1,'c');
insert into clienti(id,account,nome) values(4,1,'d');

insert into ristoratori(id,account,nome,indirizzo, telefono) values(1,1,'a','a','123');
  
insert into orari_apertura_ristorante(ristorante, apertura, chiusura, giorno) values(1, '10:00', '13:00', 'Lunedì');

select * from orari_apertura_ristorante;

delete from ristoratori where 1 = 1;
