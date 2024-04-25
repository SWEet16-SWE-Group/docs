insert into accounts values(1);
insert into profili values(1,1);
insert into profili values(2,1);
insert into ristoratori values(2);

select assert(insert_cliente(1) = 1) as "insert_cliente: nuovo                         " \G ;
select assert(insert_cliente(1) = 0) as "insert_cliente: già esistente in clienti      " \G ;
select assert(insert_cliente(2) = 0) as "insert_cliente: già esistente in ristoratori  " \G ;
select assert(insert_cliente(3) = 0) as "insert_cliente: non esistente in profili      " \G ;
