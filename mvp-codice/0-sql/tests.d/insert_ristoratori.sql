insert into accounts values(1);
insert into profili values(1,1);
insert into profili values(2,1);
insert into clienti values(2);

select assert(insert_ristoratori(1) = 1) as "insert_ristoratori: nuovo                         " \G ;
select assert(insert_ristoratori(1) = 0) as "insert_ristoratori: già esistente in clienti      " \G ;
select assert(insert_ristoratori(2) = 0) as "insert_ristoratori: già esistente in ristoratori  " \G ;
select assert(insert_ristoratori(3) = 0) as "insert_ristoratori: non esistente in profili      " \G ;
