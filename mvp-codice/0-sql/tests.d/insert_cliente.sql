insert into accounts values(1);
insert into profili values(1,1);
insert into profili values(2,1);
insert into ristoratori values(2);

select assert(insert_cliente(1) = 1, 'insert_cliente: nuovo');
select assert(insert_cliente(1) = 0, 'insert_cliente: già esistente in clienti');
select assert(insert_cliente(2) = 0, 'insert_cliente: già esistente in ristoratori');
select assert(insert_cliente(3) = 0, 'insert_cliente: non esistente in profili');
