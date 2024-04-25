insert into accounts values(1);
insert into profili values(1,1);
insert into profili values(2,1);
insert into clienti values(2);

select assert(insert_ristoratori(1) = 1, 'insert_ristoratori: nuovo');
select assert(insert_ristoratori(1) = 0, 'insert_ristoratori: già esistente in clienti');
select assert(insert_ristoratori(2) = 0, 'insert_ristoratori: già esistente in ristoratori');
select assert(insert_ristoratori(3) = 0, 'insert_ristoratori: non esistente in profili');
