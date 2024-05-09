insert into accounts values(1);
insert into profili values(1,1);
insert into profili values(2,1);
insert into profili values(3,1);
insert into profili values(4,1);
insert into clienti values(1);
insert into clienti values(2);
insert into ristoratori values(3);
insert into ristoratori values(4);

select assert(insert_messaggio(2,4) = 1, 'insert_messaggio: cliente -> ristoratore');
select assert(insert_messaggio(3,1) = 1, 'insert_messaggio: ristoratore -> cliente');
select assert(insert_messaggio(1,2) = 0, 'insert_messaggio: cliente -> cliente');
select assert(insert_messaggio(3,4) = 0, 'insert_messaggio: ristoratore -> ristoratore');
select assert(insert_messaggio(2,2) = 0, 'insert_messaggio: self -> self: cliente');
select assert(insert_messaggio(3,3) = 0, 'insert_messaggio: self -> self: ristoratore');
